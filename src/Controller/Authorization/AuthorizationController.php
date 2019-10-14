<?php

namespace Src\Controller\Authorization;


use Src\Controller\Authorization\Request\AuthorizeBoardRequest;
use Src\Controller\Authorization\Request\AuthorizeUserDeviceRequest;
use Src\Controller\Authorization\Request\AuthorizeUserRequest;
use Src\Controller\Authorization\Response\BoardAuthorizationResponse;
use Src\Controller\Controller;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Authorization\AuthorizationService;
use Src\Service\Authorization\TokenService;
use Src\Service\User\UserDeviceService;
use Src\Utils\StringUtils;

class AuthorizationController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->authorizeBoard();
            case Configuration::USER:
                return $this->authorizeUser();
            case Configuration::USER_DEVICE:
                return $this->authorizeUserDevice();
            case Configuration::SERVER:
                return $this->authorizeServer();
        }
        return self::notFoundResponse();
    }

    private function authorizeBoard()
    {
        $activateRequest = new AuthorizeBoardRequest($this->requestBody);
        $expireTime = Configuration::BOARD_TOKEN_EXPIRE_INTERVAL;
        $response = $this->generateNewToken($activateRequest->board_id, $activateRequest->authorized_code, $expireTime, true);
        return $response;
    }

    private function authorizeUser()
    {
        $activateRequest = new AuthorizeUserRequest($this->requestBody);
        $expireTime = Configuration::USER_TOKEN_EXPIRE_INTERVAL;
        $response = $this->generateNewToken($activateRequest->uuid, $activateRequest->authorized_code, $expireTime, false);
        return $response;
    }

    private function authorizeUserDevice()
    {
        $activateRequest = new AuthorizeUserDeviceRequest($this->requestBody);
        $expireTime = Configuration::USER_DEVICE_TOKEN_EXPIRE_INTERVAL;
        $response = $this->generateNewToken($activateRequest->device_id, $activateRequest->authorized_code, $expireTime, true);
        return $response;
    }

    private function authorizeServer()
    {
        return self::notFoundResponse();
    }

    private function generateNewToken($uuid, $code, $expireTime, $isDeleteOldToken)
    {
        $a = AuthorizationService::getInstance()->findFirstByIDAndCode($uuid, $code, $this->configuration);
        if ($a != null) {
            $tokens = StringUtils::trimStringToArrayWithNonEmptyElement(",", $a->tokens);
            // TODO
            // Log

            if ($isDeleteOldToken) {
                // Find and delete all other token with the board id
                foreach ($tokens as $tokenId) {
                    TokenService::getInstance()->delete((int)$tokenId);
                }
            }

            // Generate new token
            $tokenString = StringUtils::generateRandomString(Configuration::TOKEN_LENGTH);
            $tokenId = TokenService::getInstance()->insert(array("authorized_id" => (int)$a->id,
                "token" => $tokenString,
                "expired_interval" => $expireTime));

            if ($isDeleteOldToken) {
                $tokens = array($tokenId);
            } else {
                array_push($tokens, "$tokenId");
            }

            $updatedTokens = StringUtils::arrayToString(",",$tokens);
            AuthorizationService::getInstance()->update(array('id' => $a->id,
                "tokens" => $updatedTokens));

            $boardAuthorizationResponse = new BoardAuthorizationResponse();
            $boardAuthorizationResponse->token = $tokenString;
            $boardAuthorizationResponse->expired_interval = $expireTime;
            $boardAuthorizationResponse->number_of_valid_access = sizeof($tokens);

            return Controller::jsonEncodedResponse($boardAuthorizationResponse);
        }

        return self::notFoundResponse();
    }
}
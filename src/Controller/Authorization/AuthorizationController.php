<?php

namespace Src\Controller\Authorization;


use Src\Controller\Authorization\Request\AuthorizeBoardRequest;
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
        $a = AuthorizationService::getInstance()->findFirstByIDAndCode($activateRequest->board_id, $activateRequest->authorized_code);
        if ($a != null) {
            $tokens = StringUtils::trimStringToArrayWithNonEmptyElement(",", $a->tokens);
            // Find and delete all other token with the board id
            foreach ($tokens as $tokenId) {
                TokenService::getInstance()->delete((int)$tokenId);
            }

            // Generate new token
            $tokenString = StringUtils::generateRandomString(Configuration::TOKEN_LENGTH);
            $expireTime = Configuration::BOARD_TOKEN_EXPIRE_INTERVAL;
            $tokenId = TokenService::getInstance()->insert(array("authorized_id" => (int)$a->id,
                "token" => $tokenString,
                "expired_interval" => $expireTime));
            AuthorizationService::getInstance()->update(array('id' => $a->id,
                "tokens" => "$tokenId"));

            $boardAuthorizationResponse = new BoardAuthorizationResponse();
            $boardAuthorizationResponse->token = $tokenString;
            $boardAuthorizationResponse->expired_interval = $expireTime;

            return Controller::jsonEncodedResponse($boardAuthorizationResponse);
        }

        return self::notFoundResponse();
    }

    private function authorizeUser()
    {
        return self::notFoundResponse();
    }

    private function authorizeUserDevice()
    {
        $result = UserDeviceService::getInstance()->find($this->id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function authorizeServer()
    {
        return self::notFoundResponse();
    }
}
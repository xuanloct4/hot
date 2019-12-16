<?php

namespace Src\Controller\Others;


use Src\Controller\PreprocessingController;
use Src\Service\Authorization\AuthorizationService;
use Src\Service\Authorization\TokenService;
use Src\System\Configuration;
use Src\Utils\StringUtils;

class LogoutController extends PreprocessingController
{
    function processPOSTRequest()
    {
        return $this->logout();
    }


    private function logout()
    {
        try {
            Configuration::getInstance()->getConnection()->beginTransaction();
            TokenService::getInstance()->delete($this->token->id);
            $updatedTokenIds = array();
            $tokenIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $this->authorization->tokens);
            foreach ($tokenIds as $tokenId) {
                if (!StringUtils::compareStringIgnoreCase($tokenId, $this->token->id)) {
                    array_push($updatedTokenIds, $tokenId);
                }
            }

            AuthorizationService::getInstance()->update(array("id" => $this->authorization->id,
                "tokens" => $updatedTokenIds));
            Configuration::getInstance()->getConnection()->commit();

            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            Configuration::getInstance()->getConnection()->rollBack();
            return self::respondUnprocessableEntity();
        }
    }
}

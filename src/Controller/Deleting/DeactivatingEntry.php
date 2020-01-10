<?php

namespace Src\Controller\Deleting;


use Src\Controller\PreprocessingController;
use Src\Definition\Comparison;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\StringUtils;

class DeactivatingEntry extends PreprocessingController
{
    private $id;
    private $idComponentNumber = 3;

    function processDELETERequest()
    {
        $num = Configuration::BASE_URL_COMPONENT_NUMBER + $this->idComponentNumber;
        if (sizeof($this->uriComponents) > $num) {
            $this->id = $this->uriComponents[$num];
        }
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->updateDeactivatedBoardConfiguration();
            case Configuration::USER:
                return $this->updateDeactivatedUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->updateDeactivatedUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->updateDeactivatedServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function updateDeactivatedBoardConfiguration()
    {
        try {
            $boardEntity = $this->interceptData;
            $targetBoardConfiguration = BoardConfigurationService::getInstance()->findFirst($this->id);
            if ($boardEntity != null && $boardEntity->scopes != null ) {
                if($targetBoardConfiguration != null && $targetBoardConfiguration->scopes != null &&
                    (StringUtils::compareScope($boardEntity->scopes, $targetBoardConfiguration->scopes) == Comparison::descending)) {
                    BoardConfigurationService::getInstance()->update(array("id" => $this->id,
                        "is_activated" => b'0'));
                    return $this->jsonEncodedResponse(null);
                    }
                }
            return self::respondUnprocessableEntity();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeactivatedUserConfiguration()
    {
        try {
            $userEntities = $this->interceptData;
            $targetUser = UserService::getInstance()->findFirst($this->id);
            if ($userEntities != null && $userEntities->scopes != null ) {
                if($targetUser != null && $targetUser->scopes != null &&
                    (StringUtils::compareScope($userEntities->scopes, $targetUser->scopes) == Comparison::descending)) {
                    UserService::getInstance()->update(array("id" => $this->id,
                        "is_activated" => b'0'));
                    return $this->jsonEncodedResponse(null);
                }
            }
            return self::respondUnprocessableEntity();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeactivatedUserDeviceConfiguration()
    {
        try {
            $userDeviceEntities = $this->interceptData;
            $targetUserDevice = UserDeviceService::getInstance()->findFirst($this->id);
            if ($userDeviceEntities != null && $userDeviceEntities->scopes != null ) {
                if($targetUserDevice != null && $targetUserDevice->scopes != null &&
                    (StringUtils::compareScope($userDeviceEntities->scopes, $targetUserDevice->scopes) == Comparison::descending)) {
                    UserDeviceService::getInstance()->update(array("id" => $this->id,
                        "is_activated" => b'0'));
                    return $this->jsonEncodedResponse(null);
                }
            }
            return self::respondUnprocessableEntity();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeactivatedServerConfiguration()
    {
        try {
            $serverEntities = $this->interceptData;
            $targetServer = ServerConfigurationService::getInstance()->findFirst($this->id);
            if ($serverEntities != null && $serverEntities->scopes != null ) {
                if($targetServer != null && $targetServer->scopes != null &&
                    (StringUtils::compareScope($serverEntities->scopes, $targetServer->scopes) == Comparison::descending)) {
                    ServerConfigurationService::getInstance()->update(array("id" => $this->id,
                        "is_activated" => b'0'));
                    return $this->jsonEncodedResponse(null);
                }
            }
            return self::respondUnprocessableEntity();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

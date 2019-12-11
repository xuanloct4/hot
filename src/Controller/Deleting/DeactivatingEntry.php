<?php

namespace Src\Controller\Deleting;


use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;

class DeactivatingEntry extends PreprocessingController
{
    private $id;
    private $idComponentNumber = 3;

    function processDELETERequest()
    {
        if (sizeof($this->uriComponents) > Configuration::BASE_URL_COMPONENT_NUMBER + $this->idComponentNumber) {
            $this->id = Configuration::getConfiguration($this->uriComponents[Configuration::BASE_URL_COMPONENT_NUMBER + $this->idComponentNumber]);
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
            BoardConfigurationService::getInstance()->update(array("id" => $this->id,
                "is_activated" => b'0'));
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeactivatedUserConfiguration()
    {
        try {
            UserService::getInstance()->update(array("id" => $this->id,
                "is_activated" => b'0'));
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeactivatedUserDeviceConfiguration()
    {
        try {
            UserDeviceService::getInstance()->update(array("id" => $this->id,
                "is_activated" => b'0'));
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeactivatedServerConfiguration()
    {
        try {
            ServerConfigurationService::getInstance()->update(array("id" => $this->id,
                "is_activated" => b'0'));
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

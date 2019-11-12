<?php

namespace Src\Controller\Deleting;

use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;

class HardDeletingConfiguration extends PreprocessingController
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
                return $this->deletingBoardConfiguration();
            case Configuration::USER:
                return $this->deletingUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->deletingUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->deletingServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function deletingBoardConfiguration() {
        try {
            BoardConfigurationService::getInstance()->delete($this->id);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function deletingUserConfiguration() {
        try {
            UserService::getInstance()->delete($this->id);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function deletingUserDeviceConfiguration() {
        try {
            UserDeviceService::getInstance()->delete($this->id);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function deletingServerConfiguration() {
        try {
            ServerConfigurationService::getInstance()->delete($this->id);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

<?php

namespace Src\Controller\Deleting;


use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;

class SoftDeletingConfiguration extends PreprocessingController
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
                return $this->updateDeletedBoardConfiguration();
            case Configuration::USER:
                return $this->updateDeletedUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->updateDeletedUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->updateDeletedServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function updateDeletedBoardConfiguration() {
        try {
            BoardConfigurationService::getInstance()->update(array("id" => $this->id,
                "is_deleted" => b'1'));
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeletedUserConfiguration() {
        try {
            UserService::getInstance()->update(array("id" => $this->id,
                "is_deleted" => b'1'));
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeletedUserDeviceConfiguration() {
        try {
            UserDeviceService::getInstance()->update(array("id" => $this->id,
                "is_deleted" => b'1'));
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeletedServerConfiguration() {
        try {
            ServerConfigurationService::getInstance()->update(array("id" => $this->id,
                "is_deleted" => b'1'));
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

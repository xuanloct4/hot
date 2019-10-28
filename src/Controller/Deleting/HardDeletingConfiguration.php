<?php

namespace Src\Controller\Deleting;


use Src\Controller\Deleting\Request\DeleteConfigurationRequest;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;

class HardDeletingConfiguration extends PreprocessingController
{
    function processDELETERequest()
    {
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
            $request = new DeleteConfigurationRequest($this->requestBody);
            BoardConfigurationService::getInstance()->delete($request->id);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function deletingUserConfiguration() {
        try {
            $request = new DeleteConfigurationRequest($this->requestBody);
            UserService::getInstance()->delete($request->id);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function deletingUserDeviceConfiguration() {
        try {
            $request = new DeleteConfigurationRequest($this->requestBody);
            UserDeviceService::getInstance()->delete($request->id);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function deletingServerConfiguration() {
        try {
            $request = new DeleteConfigurationRequest($this->requestBody);
            ServerConfigurationService::getInstance()->delete($request->id);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

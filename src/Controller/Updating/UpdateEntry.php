<?php

namespace Src\Controller\Updating;


use Src\Controller\PreprocessingController;
use Src\Controller\Updating\Request\UpdateBoardConfigurationRequest;
use Src\Controller\Updating\Request\UpdateServerConfigurationRequest;
use Src\Controller\Updating\Request\UpdateUserConfigurationRequest;
use Src\Controller\Updating\Request\UpdateUserDeviceConfiguationRequest;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;

class UpdateEntry extends PreprocessingController
{
    function processPUTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->updatingBoardConfiguration();
            case Configuration::USER:
                return $this->updatingUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->updatingUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->updatingServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function updatingBoardConfiguration()
    {
        try {
            $request = new UpdateBoardConfigurationRequest($this->requestBody);
            $arr = $request->toArray();
            BoardConfigurationService::getInstance()->update($arr);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updatingUserConfiguration()
    {
        try {
            $request = new UpdateUserConfigurationRequest($this->requestBody);
            $arr = $request->toArray();
            UserService::getInstance()->update($arr);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updatingUserDeviceConfiguration()
    {
        try {
            $request = new UpdateUserDeviceConfiguationRequest($this->requestBody);
            $arr = $request->toArray();
            UserDeviceService::getInstance()->update($arr);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updatingServerConfiguration()
    {
        try {
            $request = new UpdateServerConfigurationRequest($this->requestBody);
            $arr = $request->toArray();
            ServerConfigurationService::getInstance()->update($arr);
            return $this->jsonEncodedResponse(null);
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

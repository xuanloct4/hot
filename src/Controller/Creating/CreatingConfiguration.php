<?php

namespace Src\Controller\Creating;


use Src\Controller\Creating\Request\CreateBoardConfigurationRequest;
use Src\Controller\Creating\Request\CreateServerConfigurationRequest;
use Src\Controller\Creating\Request\CreateUserConfigurationRequest;
use Src\Controller\Creating\Request\CreateUserDeviceConfiguationRequest;
use Src\Controller\Creating\Response\CreateConfigurationResponse;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;

class CreatingConfiguration extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->creatingBoardConfiguration();
            case Configuration::USER:
                return $this->creatingUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->creatingUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->creatingServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function creatingBoardConfiguration()
    {
        try {
            $request = new CreateBoardConfigurationRequest($this->requestBody);
            $arr = $request->toArray();
            $id = BoardConfigurationService::getInstance()->insert($arr);
            return $this->jsonEncodedResponse(new CreateConfigurationResponse($id));
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }

    }

    public function creatingUserConfiguration()
    {
        try {
            $request = new CreateUserConfigurationRequest($this->requestBody);
            $arr = $request->toArray();
            $id = UserService::getInstance()->insert($arr);
            return $this->jsonEncodedResponse(new CreateConfigurationResponse($id));
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function creatingUserDeviceConfiguration()
    {
        try {
            $request = new CreateUserDeviceConfiguationRequest($this->requestBody);
            $arr = $request->toArray();
            $id = UserDeviceService::getInstance()->insert($arr);
            return $this->jsonEncodedResponse(new CreateConfigurationResponse($id));
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function creatingServerConfiguration()
    {
        try {
            $request = new CreateServerConfigurationRequest($this->requestBody);
            $arr = $request->toArray();
            $id = ServerConfigurationService::getInstance()->insert($arr);
            return $this->jsonEncodedResponse(new CreateConfigurationResponse($id));
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

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

class CreatingEntry extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->creatingBoardEntry();
            case Configuration::USER:
                return $this->creatingUserEntry();
            case Configuration::USER_DEVICE:
                return $this->creatingUserDeviceEntry();
            case Configuration::SERVER:
                return $this->creatingServerEntry();
        }
        return self::notFoundResponse();
    }

    public function creatingBoardEntry()
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

    public function creatingUserEntry()
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

    public function creatingUserDeviceEntry()
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

    public function creatingServerEntry()
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

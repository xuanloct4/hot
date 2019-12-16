<?php

namespace Src\Controller\PushNotification;


use Src\Controller\PreprocessingController;
use Src\Controller\PushNotification\Request\UserDeviceRegisterRequest;
use Src\Definition\Configuration;
use Src\Service\User\UserDeviceService;

class RegisterController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->registerBoard();
            case Configuration::USER:
                return $this->registerUser();
            case Configuration::USER_DEVICE:
                $userDeviceRegisterRequest = new UserDeviceRegisterRequest($this->requestBody);
                return $this->registerUserDevice($userDeviceRegisterRequest);
            case Configuration::SERVER:
                return $this->registerServer();
        }
        return self::notFoundResponse();
    }

    private function registerBoard() {
        //TODO
        return self::notFoundResponse();
    }

    private function registerUser() {
        //TODO
        return self::notFoundResponse();
    }

    private function registerUserDevice(UserDeviceRegisterRequest $userDeviceRegisterRequest) {
        //TODO
        $userDeviceConfiguration = $this->interceptData;
        UserDeviceService::getInstance()->update(array("id" => $userDeviceConfiguration->id,
            "push_registration_token" => $userDeviceRegisterRequest->device_token));
    }

   private function registerServer() {
        //TODO
       return self::notFoundResponse();
   }
}

<?php

namespace Src\Controller\PushNotification;


use Src\Controller\PreprocessingController;

class RegisterController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::USER_DEVICE:
                return $this->registerUserDevice();
        }
        return self::notFoundResponse();
    }

   private function registerUserDevice() {
        //TODO
   }
}

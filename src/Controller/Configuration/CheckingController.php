<?php

namespace Src\Controller\Configuration;


use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;

class CheckingController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->checkingBoardConfiguration();
            case Configuration::USER:
                return $this->checkingUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->checkingUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->checkingServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function checkingBoardConfiguration() {

    }

    public function checkingUserConfiguration() {

    }

    public function checkingUserDeviceConfiguration() {

    }

    public function checkingServerConfiguration() {

    }
}
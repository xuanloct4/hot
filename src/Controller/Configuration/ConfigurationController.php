<?php

namespace Src\Controller\Configuration;


use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;

class ConfigurationController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->findBoardConfiguration();
            case Configuration::USER:
                return $this->findUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->findUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->findServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function findBoardConfiguration() {

    }

    public function findUserConfiguration() {

    }

    public function findUserDeviceConfiguration() {

    }

    public function findServerConfiguration() {

    }
}

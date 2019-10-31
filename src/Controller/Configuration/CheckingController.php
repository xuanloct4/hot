<?php

namespace Src\Controller\Configuration;


use Src\Controller\Configuration\Request\ConfigurationRequest;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Definition\Constants;
use Src\Service\Board\BoardConfigurationService;

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
        $configurationRequest = new ConfigurationRequest($this->requestBody);
        $boardID = $this->requestHeaders[Constants::BoardID];
        $board = BoardConfigurationService::getInstance()->findFirst($boardID);
        if($board) {

        }
        return self::notFoundResponse();
    }

    public function checkingUserConfiguration() {

    }

    public function checkingUserDeviceConfiguration() {

    }

    public function checkingServerConfiguration() {

    }
}

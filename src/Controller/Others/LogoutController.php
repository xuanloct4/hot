<?php

namespace Src\Controller\Others;


use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;

class LogoutController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->logoutBoard();
            case Configuration::USER:
                return $this->logoutUser();
            case Configuration::USER_DEVICE:
                return $this->logoutUserDevice();
            case Configuration::SERVER:
                return $this->logoutServer();
        }
        return self::notFoundResponse();
    }

    public function logoutBoard() {

    }

    public function logoutUser() {

    }

    public function logoutUserDevice() {

    }

    public function logoutServer() {

    }
}

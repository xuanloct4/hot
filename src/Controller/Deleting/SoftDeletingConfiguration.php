<?php

namespace Src\Controller\Deleting;


use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;

class SoftDeletingConfiguration extends PreprocessingController
{
    //TODO
    function processDELETERequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->updateDeletedBoardConfiguration();
            case Configuration::USER:
                return $this->updateDeletedUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->updateDeletedUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->updateDeletedServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function updateDeletedBoardConfiguration() {

    }

    public function updateDeletedUserConfiguration() {

    }

    public function updateDeletedUserDeviceConfiguration() {

    }

    public function updateDeletedServerConfiguration() {

    }
}

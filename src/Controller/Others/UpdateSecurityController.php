<?php

namespace Src\Controller\Others;


use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;

class UpdateSecurityController extends PreprocessingController
{
    function processPUTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->updateBoardSecurity();
            case Configuration::USER:
                return $this->updateUserSecurity();
            case Configuration::USER_DEVICE:
                return $this->updateUserDeviceSecurity();
            case Configuration::SERVER:
                return $this->updateServerSecurity();
        }
        return self::notFoundResponse();
    }



    private function updateBoardSecurity()
    {

    }

    private function updateUserSecurity()
    {

    }

    private function updateUserDeviceSecurity()
    {

    }

    private function updateServerSecurity()
    {

    }
}

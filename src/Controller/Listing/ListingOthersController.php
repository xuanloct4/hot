<?php

namespace Src\Controller\Listing;


use Src\Controller\Configuration\Response\ConfigurationResponse;
use Src\Controller\Configuration\Response\BoardConfigurationResponse;
use Src\Controller\Configuration\Response\UserConfigurationResponse;
use Src\Controller\Configuration\Response\UserDeviceConfigurationResponse;
use Src\Controller\Controller;
use Src\Controller\PreprocessingController;
use Src\Definition\Comparison;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\StringUtils;

class ListingOthersController extends PreprocessingController
{
    function processGETRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->getAllBoardConfiguration();
            case Configuration::USER:
                return $this->getAllUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->getAllUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->getAllServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function getAllBoardConfiguration()
    {
        try {
            $boardConfigEntities = BoardConfigurationService::getInstance()->findAll();
            $boardConfigurations = array();
            if ($boardConfigEntities != null && sizeof($boardConfigEntities) > 0) {
                for ($i = 0; $i < sizeof($boardConfigEntities); $i++) {
                    $boardConfigEntity = $boardConfigEntities[$i];
                    if($boardConfigEntity->scopes != null &&
                        (StringUtils::compareScope($this->scopes, $boardConfigEntity->scopes) == Comparison::descending)) {
                        $boardConfiguration =  new BoardConfigurationResponse($boardConfigEntity);
                        array_push($boardConfigurations, $boardConfiguration);
                    }

                }

                return Controller::jsonEncodedResponse($boardConfigurations);
            }
            return Controller::jsonEncodedResponse(array());
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function getAllUserConfiguration()
    {
        try {
            $userEntities = UserService::getInstance()->findAll();
            $users = array();
            if ($userEntities != null && sizeof($userEntities) > 0) {
                for ($i = 0; $i < sizeof($userEntities); $i++) {
                    $userEntity = $userEntities[$i];
                    if($userEntity->scopes != null &&
                        (StringUtils::compareScope($this->scopes, $userEntity->scopes) == Comparison::descending)) {
                        $user =  new UserConfigurationResponse($userEntity);
                        array_push($users, $user);
                    }

                }

                return Controller::jsonEncodedResponse($users);
            }
            return Controller::jsonEncodedResponse(array());
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function getAllUserDeviceConfiguration()
    {
        try {
            $userDeviceEntities = UserDeviceService::getInstance()->findAll();
            $userDevices = array();
            if ($userDeviceEntities != null && sizeof($userDeviceEntities) > 0) {
                for ($i = 0; $i < sizeof($userDeviceEntities); $i++) {
                    $userDeviceEntity = $userDeviceEntities[$i];
                    if($userDeviceEntity->scopes != null &&
                        (StringUtils::compareScope($this->scopes, $userDeviceEntity->scopes) == Comparison::descending)) {
                        $userDevice =  new UserDeviceConfigurationResponse($userDeviceEntity);
                        array_push($userDevices, $userDevice);
                    }

                }

                return Controller::jsonEncodedResponse($userDevices);
            }
            return Controller::jsonEncodedResponse(array());
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function getAllServerConfiguration()
    {

        return self::notFoundResponse();
    }
}

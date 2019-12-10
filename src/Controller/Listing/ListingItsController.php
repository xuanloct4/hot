<?php

namespace Src\Controller\Listing;


use Src\Controller\Configuration\Response\ConfigurationResponse;
use Src\Controller\Configuration\Response\BoardConfigurationResponse;
use Src\Controller\Configuration\Response\UserConfigurationResponse;
use Src\Controller\Configuration\Response\UserDeviceConfigurationResponse;
use Src\Controller\Controller;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Utils\StringUtils;

class ListingItsController extends PreprocessingController
{
    private $id;

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
    }

    public function getAllBoardConfiguration()
    {
        try {
            switch ($this->chanelId) {
                case Configuration::BOARD:
                    $boardEntity = $this->interceptData;
                    $boardConfiguration = new BoardConfigurationResponse($boardEntity);
                    $boardConfigurations = array($boardConfiguration);
                    return Controller::jsonEncodedResponse($boardConfigurations);
                case Configuration::USER:
                    $userEntity = $this->interceptData;
                    $boardIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userEntity->board_id);

                    $boardConfigurations = array();
                    for ($i = 0; $i < sizeof($boardIds); $i++) {
                        $boardId = trim($boardIds[$i]);
                        if (strcmp("",$boardId) != 0) {
                            $boardEntity = BoardConfigurationService::getInstance()->findFirst($boardId);
                            if ($boardEntity != null) {
                                $boardConfiguration = new BoardConfigurationResponse($boardEntity);
                                array_push($boardConfigurations, $boardConfiguration);
                            }
                        }
                    }

                    return Controller::jsonEncodedResponse($boardConfigurations);
                case Configuration::USER_DEVICE:
                    $userDeviceEntity = $this->interceptData;
                    $boardIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userDeviceEntity->board_id);

                    $boardConfigurations = array();
                    for ($i = 0; $i < sizeof($boardIds); $i++) {
                        $boardId = trim($boardIds[$i]);
                        if (strcmp("", $boardId) != 0) {
                            $boardEntity = BoardConfigurationService::getInstance()->findFirst($boardId);
                            if ($boardEntity != null) {
                                $boardConfiguration = new BoardConfigurationResponse($boardEntity);
                                array_push($boardConfigurations, $boardConfiguration);
                            }
                        }
                    }

                    return Controller::jsonEncodedResponse($boardConfigurations);

                case Configuration::SERVER:

            }

            return self::notFoundResponse();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function getAllUserConfiguration()
    {
        try {
            switch ($this->chanelId) {
                case Configuration::BOARD:
                    $boardEntity = $this->interceptData;
                    $userIds = StringUtils::trimStringToArrayWithNonEmptyElement("|",$boardEntity->user_id);

                    $userConfigurations = array();
                    for ($i = 0; $i < sizeof($userIds); $i++) {
                        $userId = trim($userIds[$i]);
                        if (strcmp("", $userId) != 0) {
                            $userEntity = BoardConfigurationService::getInstance()->findFirst($userId);
                            if ($userEntity != null) {
                                $userConfiguration = new UserConfigurationResponse($userEntity);
                                array_push($userConfigurations, $userConfiguration);
                            }
                        }
                    }

                    return Controller::jsonEncodedResponse($userConfigurations);
                case Configuration::USER:
                    $userEntity = $this->interceptData;
                    $userConfiguration = new UserConfigurationResponse($userEntity);
                    $userConfigurations = array($userConfiguration);
                    return Controller::jsonEncodedResponse($userConfigurations);

                case Configuration::USER_DEVICE:
                    $userDeviceEntity = $this->interceptData;
                    $userIds = StringUtils::trimStringToArrayWithNonEmptyElement("|",$userDeviceEntity->user_id);

                    $userConfigurations = array();
                    for ($i = 0; $i < sizeof($userIds); $i++) {
                        $userId = trim($userIds[$i]);
                        if (strcmp("", $userId) != 0) {
                            $userEntity = BoardConfigurationService::getInstance()->findFirst($userId);
                            if ($userEntity != null) {
                                $userConfiguration = new UserConfigurationResponse($userEntity);
                                array_push($userConfigurations, $userConfiguration);
                            }
                        }
                    }

                    return Controller::jsonEncodedResponse($userConfigurations);

                case Configuration::SERVER:

            }

            return self::notFoundResponse();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function getAllUserDeviceConfiguration()
    {
        try {
            switch ($this->chanelId) {
                case Configuration::BOARD:
                    $boardEntity = $this->interceptData;
                    $userDeviceIds = StringUtils::trimStringToArrayWithNonEmptyElement("|",$boardEntity->user_device_id);

                    $userDeviceConfigurations = array();
                    for ($i = 0; $i < sizeof($userDeviceIds); $i++) {
                        $userDeviceId = trim($userDeviceIds[$i]);
                        if (strcmp("",$userDeviceId) != 0) {
                            $userDeviceEntity = BoardConfigurationService::getInstance()->findFirst($userDeviceId);
                            if ($userDeviceEntity != null) {
                                $userDeviceConfiguration = new UserDeviceConfigurationResponse($userDeviceEntity);
                                array_push($userDeviceConfigurations, $userDeviceConfiguration);
                            }
                        }
                    }

                    return Controller::jsonEncodedResponse($userDeviceConfigurations);

                case Configuration::USER:
                    $userEntity = $this->interceptData;
                    $userDeviceIds = StringUtils::trimStringToArrayWithNonEmptyElement("|",$userEntity->user_device_id);

                    $userDeviceConfigurations = array();
                    for ($i = 0; $i < sizeof($userDeviceIds); $i++) {
                        $userDeviceId = trim($userDeviceIds[$i]);
                        if (strcmp("",$userDeviceId) != 0) {
                            $userDeviceEntity = BoardConfigurationService::getInstance()->findFirst($userDeviceId);
                            if ($userDeviceEntity != null) {
                                $userDeviceConfiguration = new UserDeviceConfigurationResponse($userDeviceEntity);
                                array_push($userDeviceConfigurations, $userDeviceConfiguration);
                            }
                        }
                    }

                    return Controller::jsonEncodedResponse($userDeviceConfigurations);
                case Configuration::USER_DEVICE:
                    $userDeviceEntity = $this->interceptData;
                    $userDeviceConfiguration = new UserDeviceConfigurationResponse($userDeviceEntity);

                    return Controller::jsonEncodedResponse($userDeviceConfiguration);
                case Configuration::SERVER:

            }

            return self::notFoundResponse();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function getAllServerConfiguration()
    {
            return self::notFoundResponse();
    }
}

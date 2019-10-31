<?php

namespace Src\Controller\Detail;


use Src\Controller\Activation\Response\ConfigurationResponse;
use Src\Controller\Configuration\Response\BoardConfigurationResponse;
use Src\Controller\Configuration\Response\ServerConfigurationResponse;
use Src\Controller\Configuration\Response\UserConfigurationResponse;
use Src\Controller\Configuration\Response\UserDeviceConfigurationResponse;
use Src\Controller\Controller;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Definition\Constants;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;

class DetailController extends PreprocessingController
{
    private $id;

    function processGETRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->getBoardConfiguration();
            case Configuration::USER:
                return $this->getUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->getUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->getServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function getBoardConfiguration()
    {
        try {
            $this->id = $this->requestHeaders[Constants::BoardID];
            $boardConfigEntity = BoardConfigurationService::getInstance()->findFirst($this->id);
            if ($boardConfigEntity != null) {

                $boardConfiguration = new BoardConfigurationResponse($boardConfigEntity);
                $configurations = ConfigurationService::getInstance()->findByConfigIds($boardConfigEntity->configuration, $boardConfigEntity->scopes);
                $boardConfiguration->configuration = ConfigurationResponse::toConfigurationResponses($configurations);

                return Controller::jsonEncodedResponse($boardConfiguration);
            }
            return self::notFoundResponse();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }


    public function getUserConfiguration()
    {
        try {
            $this->id = $this->requestHeaders[Constants::UserID];
            $userConfigEntity = UserService::getInstance()->findFirst($this->id);
            if ($userConfigEntity != null) {

                $userConfigurationResponse = new UserConfigurationResponse($userConfigEntity);
                $configurations = ConfigurationService::getInstance()->findByConfigIds($userConfigEntity->preferences, $userConfigEntity->scopes);
                $userConfigurationResponse->preferences = ConfigurationResponse::toConfigurationResponses($configurations);

                return Controller::jsonEncodedResponse($userConfigurationResponse);
            }
            return self::notFoundResponse();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }


    public function getUserDeviceConfiguration()
    {
        try {
            $this->id = $this->requestHeaders[Constants::UserDeviceID];
            $useDeviceEntity = UserDeviceService::getInstance()->findFirst($this->id);
            if ($useDeviceEntity != null) {

                $userDeviceConfigurationResponse = new UserDeviceConfigurationResponse($useDeviceEntity);
                $configurations = ConfigurationService::getInstance()->findByConfigIds($useDeviceEntity->configuration, $useDeviceEntity->scopes);
                $userDeviceConfigurationResponse->configuration = ConfigurationResponse::toConfigurationResponses($configurations);

                return Controller::jsonEncodedResponse($userDeviceConfigurationResponse);
            }
            return self::notFoundResponse();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }


    public function getServerConfiguration()
    {
        try {
            $this->id = $this->requestHeaders[Constants::ServerID];
            $serverConfigEntity = ServerConfigurationService::getInstance()->findFirst($this->id);
            if ($serverConfigEntity != null) {

                $serverConfigurationResponse = new ServerConfigurationResponse($serverConfigEntity);
                $configurations = ConfigurationService::getInstance()->findByConfigIds($serverConfigEntity->configuration, $serverConfigEntity->scopes);
                $serverConfigurationResponse->configuration = ConfigurationResponse::toConfigurationResponses($configurations);

                return Controller::jsonEncodedResponse($serverConfigurationResponse);
            }
            return self::notFoundResponse();
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

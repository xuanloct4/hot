<?php

namespace Src\Controller\Listing;


use Src\Controller\Configuration\Response\ConfigurationResponse;
use Src\Controller\Configuration\Response\BoardConfigurationResponse;
use Src\Controller\Controller;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;

class ListingItsController extends PreprocessingController
{
    private $id;
    private $idComponentNumber = 3;

    function processGETRequest()
    {
        if (sizeof($this->uriComponents) > Configuration::BASE_URL_COMPONENT_NUMBER + $this->idComponentNumber) {
            $this->id = Configuration::getConfiguration($this->uriComponents[Configuration::BASE_URL_COMPONENT_NUMBER + $this->idComponentNumber]);
        }
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

    public function getAllUserConfiguration()
    {
        try {
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

    public function getAllUserDeviceConfiguration()
    {
        try {
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

    public function getAllServerConfiguration()
    {
        try {
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
}

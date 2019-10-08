<?php

namespace Src\Controller\Activation;


use Src\Controller\Activation\Request\ActivateBoardConfigurationRequest;
use Src\Controller\Activation\Request\ActivateDeviceConfigurationRequest;
use Src\Controller\Activation\Response\BoardConfigurationResponse;
use Src\Controller\Activation\Response\ConfigurationResponse;
use Src\Controller\Activation\Response\DeviceConfigurationResponse;
use Src\Controller\Controller;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Authorization\AuthorizationService;
use Src\Service\Board\BoardConfigurationDTO;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\User\DeviceService;

class ActivationController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->activateBoardConfiguration();
            case Configuration::USER:
                return $this->activateUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->activateUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->activateServerConfiguration();
        }
        return self::notFoundResponse();
    }

    private function activateBoardConfiguration()
    {
        $activateRequest = new ActivateBoardConfigurationRequest($this->requestBody);
        $a = AuthorizationService::getInstance()->findFirstByIDAndCode($activateRequest->board_id, $activateRequest->authorized_code);
        if ($a != null) {
            $boardConfigEntity = BoardConfigurationService::getInstance()->findByAuthID($a->id);
            if ($boardConfigEntity != null) {
                // Update status is_activated = true
                $updateBoardConfigDTO = new BoardConfigurationDTO($boardConfigEntity);
                $updateBoardConfigDTO->setIsActivated(b'1');
                $updateBoardConfigDTO->setIsDeleted(b'0');
                BoardConfigurationService::getInstance()->update($updateBoardConfigDTO->toArray());
                // TODO
                //Log to log table

                $boardConfiguration = new BoardConfigurationResponse($boardConfigEntity);
                $configurations = ConfigurationService::getInstance()->findByConfigIds($boardConfigEntity->configuration, $boardConfigEntity->scopes);
                $boardConfiguration->configuration = ConfigurationResponse::toConfigurationResponses($configurations);

                return Controller::jsonEncodedResponse($boardConfiguration);
            }
        }

        return self::notFoundResponse();
    }

    private function activateUserConfiguration()
    {
        return self::notFoundResponse();
    }

    private function activateUserDeviceConfiguration()
    {
        $activateRequest = new ActivateDeviceConfigurationRequest($this->requestBody);
        $device = DeviceService::getInstance()->findByModelAndOS($activateRequest->model, $activateRequest->os);
        if ($device != null) {
            $deviceConfiguration = new DeviceConfigurationResponse($device);
            $configurations = ConfigurationService::getInstance()->findByConfigIds($device->configuration, $device->scopes);
            $deviceConfiguration->configuration = ConfigurationResponse::toConfigurationResponses($configurations);

            return Controller::jsonEncodedResponse($deviceConfiguration);
        }
        return self::notFoundResponse();
    }

    private function activateServerConfiguration()
    {
        return self::notFoundResponse();
    }
}
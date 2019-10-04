<?php

namespace Src\Controller\Activation;


use Src\Controller\Activation\Request\ActivateBoardConfigurationRequest;
use Src\Controller\Activation\Request\ActivateDeviceConfigurationRequest;
use Src\Controller\Activation\Response\BoardConfigurationResponse;
use Src\Controller\Activation\Response\ConfigurationResponse;
use Src\Controller\Activation\Response\DeviceConfigurationResponse;
use Src\Controller\Controller;
use Src\Definition\Configuration;
use Src\Service\Authorization\AuthorizationService;
use Src\Service\Board\BoardConfigurationDTO;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\User\DeviceService;

class ActivationController extends Controller
{
    private $configuration;

    public function init()
    {
        if (sizeof($this->uriComponents) > Configuration::BASE_URL_COMPONENT_NUMBER + 1) {
            $this->configuration = Configuration::getConfiguration($this->uriComponents[Configuration::BASE_URL_COMPONENT_NUMBER + 1]);
        }
    }

    protected function processGETRequest()
    {
        // TODO: Implement processGETRequest() method.
    }

    protected function processPOSTRequest()
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
    }

    protected function processPUTRequest()
    {
        // TODO: Implement processPUTRequest() method.
    }

    protected function processDELETERequest()
    {
        // TODO: Implement processDELETERequest() method.
    }

    private function activateBoardConfiguration()
    {
        $activateRequest = new ActivateBoardConfigurationRequest($this->requestBody);
        $a = AuthorizationService::getInstance()->findByIDAndCode($activateRequest->board_id, $activateRequest->authorized_code);
        if (sizeof($a) > 0) {
            $b = BoardConfigurationService::getInstance()->findByAuthID($a[0]->id);
            if (sizeof($b) > 0) {
                // Update status is_activated = true
                $boardConfigEntity = $b[0];
                $updateBoardConfigDTO = new BoardConfigurationDTO($boardConfigEntity);
                $updateBoardConfigDTO->setIsActivated(b'1');
                $updateBoardConfigDTO->setIsDeleted(b'0');
                BoardConfigurationService::getInstance()->update($updateBoardConfigDTO);
                // TODO
                //Log to log table

                $boardConfiguration = new BoardConfigurationResponse($b[0]);
                $configurations = ConfigurationService::getInstance()->findByConfigIds($b[0]->configuration, $b[0]->scopes);
                $boardConfiguration->configuration = ConfigurationResponse::toConfigurationResponses($configurations);

                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['body'] = json_encode($boardConfiguration);
                return $response;
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
        if (sizeof($device) > 0) {
            $deviceConfiguration = new DeviceConfigurationResponse($device[0]);
            $configurations = ConfigurationService::getInstance()->findByConfigIds($device[0]->configuration, $device[0]->scopes);
            $deviceConfiguration->configuration = ConfigurationResponse::toConfigurationResponses($configurations);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($deviceConfiguration);
            return $response;
        }
        return self::notFoundResponse();
    }

    private function activateServerConfiguration()
    {
        return self::notFoundResponse();
    }
}
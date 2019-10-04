<?php
namespace Src\Controller\Authorization;


use Src\Controller\Activation\Request\ActivateBoardConfigurationRequest;
use Src\Controller\Activation\Response\BoardConfigurationResponse;
use Src\Controller\Activation\Response\ConfigurationResponse;
use Src\Controller\Controller;
use Src\Definition\Comparison;
use Src\Definition\Configuration;
use Src\Definition\Constants;
use Src\Service\Authorization\AuthorizationService;
use Src\Service\Board\BoardConfigurationDTO;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\StringUtils;

class AuthorizationController extends Controller
{
    private $configuration;
    public function init()
    {
        if (sizeof($this->uriComponents) > Configuration::BASE_URL_COMPONENT_NUMBER+1) {
            $this->configuration = Configuration::getConfiguration($this->uriComponents[Configuration::BASE_URL_COMPONENT_NUMBER+1]);
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
                    return $this->authorizeBoardConfiguration();
                case Configuration::USER:
                    return $this->authorizeUserConfiguration();
                case Configuration::USER_DEVICE:
                    return $this->authorizeUserDeviceConfiguration();
                case Configuration::SERVER:
                    return $this->authorizeServerConfiguration();
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

    private function authorizeBoardConfiguration()
    {
        $activateRequest = new ActivateBoardConfigurationRequest($this->requestBody);
        $a = AuthorizationService::getInstance()->findByIDAndCode($activateRequest->board_id,$activateRequest->authorized_code);
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
                $configurations = array();
                $configIds = StringUtils::trimStringToArrayWithNonEmptyElement(",", $b[0]->configuration);
                for ($i = 0; $i < sizeof($configIds); $i++) {
                    $configId = $configIds[$i];
                    $c = ConfigurationService::getInstance()->find($configId);
                    if (sizeof($c) > 0) {
                        foreach (StringUtils::getScopes($b[0]->scopes) as $boardScope) {
                            foreach (StringUtils::getScopes($c[0]->scopes) as $configScope) {
                                $isScoped = StringUtils::compareScope($boardScope, $configScope);
                                if ($isScoped == Comparison::descending || $isScoped == Comparison::equal) {
                                    $configuration = new ConfigurationResponse($c[0]);
                                    array_push($configurations, $configuration);
                                }
                            }
                        }
                    }
                }

                // TODO
                // Sorting by update_order and updated timestamp
                $boardConfiguration->configuration = $configurations;

                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['body'] = json_encode($boardConfiguration);
                return $response;
            }
        }

        return self::notFoundResponse();
    }

    private function authorizeUserConfiguration()
    {
        return self::notFoundResponse();
    }

    private function authorizeUserDeviceConfiguration()
    {
        $result = UserDeviceService::getInstance()->find($this->id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function authorizeServerConfiguration()
    {
        return self::notFoundResponse();
    }
}
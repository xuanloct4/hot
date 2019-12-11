<?php

namespace Src\Controller\Deleting;


use Src\Controller\PreprocessingController;
use Src\Controller\Updating\Request\UpdateConfigurationRequest;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\StringUtils;

class DeactivatingConfiguration extends PreprocessingController
{
    private $id;
    private $idComponentNumber = 3;

    function processDELETERequest()
    {
        if (sizeof($this->uriComponents) > Configuration::BASE_URL_COMPONENT_NUMBER + $this->idComponentNumber) {
            $this->id = Configuration::getConfiguration($this->uriComponents[Configuration::BASE_URL_COMPONENT_NUMBER + $this->idComponentNumber]);
        }
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->updateDeactivatedBoardConfiguration();
            case Configuration::USER:
                return $this->updateDeactivatedUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->updateDeactivatedUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->updateDeactivatedServerConfiguration();
        }
        return self::notFoundResponse();
    }

    private function updateConfiguration(array $configurationIds)
    {
        try {
            if (StringUtils::isElementInArray($this->id, $configurationIds)) {
                ConfigurationService::getInstance()->update(array("id" => $this->id,
                    "is_activated" => b'0'));
                return $this->jsonEncodedResponse(null);
            } else {
                return self::notFoundResponse();
            }
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeactivatedBoardConfiguration()
    {
        $boardEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $boardEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }

    public function updateDeactivatedUserConfiguration()
    {
        $userEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userEntity->preferences);
        return $this->updateConfiguration($configurationIds);
    }

    public function updateDeactivatedUserDeviceConfiguration()
    {
        $userDeviceEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userDeviceEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }

    public function updateDeactivatedServerConfiguration()
    {
        $serverConfigurationEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $serverConfigurationEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }
}

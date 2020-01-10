<?php

namespace Src\Controller\Deleting;

use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\StringUtils;

class HardDeletingConfiguration extends PreprocessingController
{
    private $id;
    private $idComponentNumber = 4;

    function processDELETERequest()
    {
        $num = Configuration::BASE_URL_COMPONENT_NUMBER + $this->idComponentNumber;
        if (sizeof($this->uriComponents) > $num) {
            $this->id = $this->uriComponents[$num];
        }
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->deletingBoardConfiguration();
            case Configuration::USER:
                return $this->deletingUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->deletingUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->deletingServerConfiguration();
        }
        return self::notFoundResponse();
    }

    private function updateConfiguration(array $configurationIds)
    {
        try {
            if (StringUtils::isElementInArray($this->id, $configurationIds)) {
                ConfigurationService::getInstance()->delete($this->id);
                return $this->jsonEncodedResponse(null);
            } else {
                return self::notFoundResponse();
            }
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function deletingBoardConfiguration()
    {
        $boardEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $boardEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }

    public function deletingUserConfiguration()
    {
        $userEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userEntity->preferences);
        return $this->updateConfiguration($configurationIds);
    }

    public function deletingUserDeviceConfiguration()
    {
        $userDeviceEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userDeviceEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }

    public function deletingServerConfiguration()
    {
        $serverConfigurationEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $serverConfigurationEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }
}

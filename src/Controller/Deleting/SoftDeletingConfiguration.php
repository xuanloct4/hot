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

class SoftDeletingConfiguration extends PreprocessingController
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
                return $this->updateDeletedBoardConfiguration();
            case Configuration::USER:
                return $this->updateDeletedUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->updateDeletedUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->updateDeletedServerConfiguration();
        }
        return self::notFoundResponse();
    }

    private function updateConfiguration(array $configurationIds)
    {
        try {
            if (StringUtils::isElementInArray($this->id, $configurationIds)) {
                ConfigurationService::getInstance()->update(array("id" => $this->id,
                    "is_deleted" => b'1'));
                return $this->jsonEncodedResponse(null);
            } else {
                return self::notFoundResponse();
            }
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updateDeletedBoardConfiguration()
    {
        $boardEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $boardEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }

    public function updateDeletedUserConfiguration()
    {
        $userEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userEntity->preferences);
        return $this->updateConfiguration($configurationIds);
    }

    public function updateDeletedUserDeviceConfiguration()
    {
        $userDeviceEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userDeviceEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }

    public function updateDeletedServerConfiguration()
    {
        $serverConfigurationEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $serverConfigurationEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }
}

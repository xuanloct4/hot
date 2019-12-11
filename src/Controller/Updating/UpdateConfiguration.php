<?php

namespace Src\Controller\Updating;


use Src\Controller\PreprocessingController;
use Src\Controller\Updating\Request\UpdateBoardConfigurationRequest;
use Src\Controller\Updating\Request\UpdateConfigurationRequest;
use Src\Controller\Updating\Request\UpdateServerConfigurationRequest;
use Src\Controller\Updating\Request\UpdateUserConfigurationRequest;
use Src\Controller\Updating\Request\UpdateUserDeviceConfiguationRequest;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\StringUtils;

class UpdateConfiguration extends PreprocessingController
{
    function processPUTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->updatingBoardConfiguration();
            case Configuration::USER:
                return $this->updatingUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->updatingUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->updatingServerConfiguration();
        }
        return self::notFoundResponse();
    }

    private function updateConfiguration(array $configurationIds)
    {
        try {
            $request = new UpdateConfigurationRequest($this->requestBody);
            if (StringUtils::isElementInArray($request->id, $configurationIds)) {
                $arr = $request->toArray();
                ConfigurationService::getInstance()->update($arr);
                return $this->jsonEncodedResponse(null);
            } else {
                return self::notFoundResponse();
            }
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function updatingBoardConfiguration()
    {
        $boardEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $boardEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }

    public function updatingUserConfiguration()
    {
        $userEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userEntity->preferences);
        return $this->updateConfiguration($configurationIds);
    }

    public function updatingUserDeviceConfiguration()
    {
        $userDeviceEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userDeviceEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }

    public function updatingServerConfiguration()
    {
        $serverConfigurationEntity = $this->interceptData;
        $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $serverConfigurationEntity->configuration);
        return $this->updateConfiguration($configurationIds);
    }
}

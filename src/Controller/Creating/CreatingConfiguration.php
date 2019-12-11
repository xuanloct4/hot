<?php

namespace Src\Controller\Creating;


use Src\Controller\Creating\Request\CreateBoardConfigurationRequest;
use Src\Controller\Creating\Request\CreateConfigurationRequest;
use Src\Controller\Creating\Request\CreateServerConfigurationRequest;
use Src\Controller\Creating\Request\CreateUserConfigurationRequest;
use Src\Controller\Creating\Request\CreateUserDeviceConfiguationRequest;
use Src\Controller\Creating\Response\CreateConfigurationResponse;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\StringUtils;

class CreatingConfiguration extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->creatingBoardConfiguration();
            case Configuration::USER:
                return $this->creatingUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->creatingUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->creatingServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function creatingBoardConfiguration()
    {
        try {
            $boardEntity = $this->interceptData;
            $request = new CreateConfigurationRequest($this->requestBody);
            $configurationId = ConfigurationService::getInstance()->insert($request);

            $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|",$boardEntity->configuration);
            array_push($configurationIds, $configurationId);
            BoardConfigurationService::getInstance()->update(array("id" => $boardEntity->id,
                "configuration" => StringUtils::arrayToString("|", $configurationIds)));

            return $this->jsonEncodedResponse(new CreateConfigurationResponse($configurationId));
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function creatingUserConfiguration()
    {
        try {
            $userEntity = $this->interceptData;
            $request = new CreateConfigurationRequest($this->requestBody);
            $configurationId = ConfigurationService::getInstance()->insert($request);

            $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|",$userEntity->preferences);
            array_push($configurationIds, $configurationId);
            BoardConfigurationService::getInstance()->update(array("id" => $userEntity->id,
                "configuration" => StringUtils::arrayToString("|", $configurationIds)));

            return $this->jsonEncodedResponse(new CreateConfigurationResponse($configurationId));
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function creatingUserDeviceConfiguration()
    {
        try {
            $userDeviceEntity = $this->interceptData;
            $request = new CreateConfigurationRequest($this->requestBody);
            $configurationId = ConfigurationService::getInstance()->insert($request);

            $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|",$userDeviceEntity->configuration);
            array_push($configurationIds, $configurationId);
            BoardConfigurationService::getInstance()->update(array("id" => $userDeviceEntity->id,
                "configuration" => StringUtils::arrayToString("|", $configurationIds)));

            return $this->jsonEncodedResponse(new CreateConfigurationResponse($configurationId));
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }

    public function creatingServerConfiguration()
    {
        try {
            $serverConfigurationEntity = $this->interceptData;
            $request = new CreateConfigurationRequest($this->requestBody);
            $configurationId = ConfigurationService::getInstance()->insert($request);

            $configurationIds = StringUtils::trimStringToArrayWithNonEmptyElement("|",$serverConfigurationEntity->configuration);
            array_push($configurationIds, $configurationId);
            BoardConfigurationService::getInstance()->update(array("id" => $serverConfigurationEntity->id,
                "configuration" => StringUtils::arrayToString("|", $configurationIds)));

            return $this->jsonEncodedResponse(new CreateConfigurationResponse($configurationId));
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

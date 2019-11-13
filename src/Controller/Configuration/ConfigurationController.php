<?php

namespace Src\Controller\Configuration;


use Src\Controller\Configuration\Request\CriterSpecification;
use Src\Controller\Configuration\Response\ConfigurationIndexResponse;
use Src\Controller\Configuration\Response\ConfigurationResponse;
use Src\Controller\Configuration\Response\PageInfo;
use Src\Controller\Controller;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Configuration\ConfigurationService;

class ConfigurationController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->findBoardConfiguration();
            case Configuration::USER:
                return $this->findUserConfiguration();
            case Configuration::USER_DEVICE:
                return $this->findUserDeviceConfiguration();
            case Configuration::SERVER:
                return $this->findServerConfiguration();
        }
        return self::notFoundResponse();
    }

    public function findBoardConfiguration()
    {
        $configurationQuery = new ConfigurationQuery($this->requestBody);
//        var_dump($configurationQuery);
        $boardConfiguration = $this->interceptData;
        $configurationQuery->id_spec = new CriterSpecification(array("list" => $boardConfiguration->configuration,
            "isAnd" => false));

        $configurations = ConfigurationService::getInstance()->searchDB($configurationQuery);
//        var_dump($configurations);
        //TODO: sorting by update_order and last_updated_timestamp

        $pageInfo = new PageInfo();
        if ($configurationQuery->page_spec && $configurationQuery->page_spec->page) {
            $pageSize = 20;
            if ($configurationQuery->page_spec->page_size) {
                $pageSize = $configurationQuery->page_spec->page_size;
            }

            $page = $configurationQuery->page_spec->page;
            $pageInfo->page_size = $pageSize;
            $pageInfo->current_page = $page;

            $pageInfo->total_pages = round(sizeof($configurations) / $pageSize);
            if (sizeof($configurations) % $pageSize != 0) {
                $pageInfo->total_pages += 1;
            }
            $pageInfo->total_items =  sizeof($configurations);

            if (($page-1) * $pageSize + 1 > sizeof($configurations)) {
                $configurations = array();
            } else {
                $max =($page * $pageSize < sizeof($configurations)) ? $page * $pageSize : sizeof($configurations);
                $pageItems = array();
                for ($i = 0; $i < $max; $i++) {
                    array_push($pageItems, $configurations[$i]);
                }
                $configurations = $pageItems;
            }

        }

//        var_dump($configurations);
        $configurationResponse = ConfigurationResponse::toConfigurationResponses($configurations);

        $configurationIndexResponse = new ConfigurationIndexResponse();
        $configurationIndexResponse->list = $configurationResponse;
        $configurationIndexResponse->page_info = $pageInfo;
        return Controller::jsonEncodedResponse($configurationIndexResponse);
    }

    public function findUserConfiguration()
    {

    }

    public function findUserDeviceConfiguration()
    {

    }

    public function findServerConfiguration()
    {

    }
}

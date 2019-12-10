<?php

namespace Src\Controller\Configuration;


use Src\Controller\Configuration\Request\CriterSpecification;
use Src\Controller\Configuration\Request\OrderSpecification;
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

        $configurationQuery = new ConfigurationQuery($this->requestBody);
//        var_dump($configurationQuery);
        if ($this->configuration == $this->chanelId) {
            switch ($this->configuration) {
                case Configuration::BOARD:
                    $configurationQuery->id_spec = new CriterSpecification(array("list" => $this->interceptData->configuration,
                        "isAnd" => false));
                    break;
                case Configuration::USER:
                    $configurationQuery->id_spec = new CriterSpecification(array("list" => $this->interceptData->preferences,
                        "isAnd" => false));
                    break;
                case Configuration::USER_DEVICE:
                    break;
                case Configuration::SERVER:
                    break;
            }

            return $this->findConfiguration($configurationQuery);
        }
        return self::notFoundResponse();
    }

    public function findConfiguration($configurationQuery)
    {
        try {
            $order_by_list = array();
            array_push($order_by_list, new OrderSpecification("last_updated_timestamp", false));
            //TODO: sorting by update_order
            $configurationQuery->order_by_list = $order_by_list;

            $configurations = ConfigurationService::getInstance()->searchDB($configurationQuery);
//        var_dump($configurations);

            $pageInfo = new PageInfo();
            if ($configurationQuery->page_spec && $configurationQuery->page_spec->page) {
                $pageSize = 20;
                if ($configurationQuery->page_spec->page_size) {
                    $pageSize = $configurationQuery->page_spec->page_size;
                }

                $page = $configurationQuery->page_spec->page;
                $pageInfo->page_size = $pageSize;
                $pageInfo->current_page = $page;

                $pageInfo->total_pages = round(sizeof($configurations) / $pageSize - 0.5);
                if (sizeof($configurations) % $pageSize != 0) {
                    $pageInfo->total_pages += 1;
                }
                $pageInfo->total_items = sizeof($configurations);

                if (($page - 1) * $pageSize + 1 > sizeof($configurations)) {
                    $configurations = array();
                } else {
                    $max = ($page * $pageSize < sizeof($configurations)) ? $page * $pageSize : sizeof($configurations);
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
        } catch (\Exception $e) {
            return self::respondUnprocessableEntity();
        }
    }
}

<?php

namespace Src\Controller;


use Src\Definition\Configuration;

class PreprocessingController extends Controller
{
    protected $configuration;

    public function init()
    {
        if (sizeof($this->uriComponents) > Configuration::BASE_URL_COMPONENT_NUMBER + 1) {
            $this->configuration = Configuration::getConfiguration($this->uriComponents[Configuration::BASE_URL_COMPONENT_NUMBER + 1]);
        }
    }

    function processGETRequest()
    {
        return self::notFoundResponse();
    }

    function processPOSTRequest()
    {
        return self::notFoundResponse();
    }

    function processPUTRequest()
    {
        return self::notFoundResponse();
    }

    function processDELETERequest()
    {
        return self::notFoundResponse();
    }
}
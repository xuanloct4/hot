<?php

namespace Src\Controller\Configuration;


use Src\Controller\Configuration\Request\ConfigurationRequest;

class ConfigurationQuery extends ConfigurationRequest
{
    public $id_spec;
    public $order_by_list;

    public function __construct($arr)
    {
        return parent::__construct($arr);
    }
}

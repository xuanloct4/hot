<?php

namespace Src\Controller\Configuration\Request;

use Src\Controller\Request;

class ConfigurationRequest extends Request
{
    public $page_spec;

    public $update_order_spec;
    public $type_spec;
    public $scopes_spec;
    public $category_spec;
    public $is_deleted = false;
    public $is_activated = true;
    public $created_timestamp_spec;
    public $last_updated_timestamp_spec;

    public $isAnd = true;

    public function __construct($arr)
    {
        $this->page_spec = new PageSpecification($arr["page_spec"]);
        $this->update_order_spec = new CriterSpecification($arr["update_order_spec"]);
        $this->type_spec = new CriterSpecification($arr["type_spec"]);
        $this->scopes_spec = new CriterSpecification($arr["scopes"]);
        $this->category_spec = new CriterSpecification($arr["category_spec"]);
        $this->is_deleted = $arr["is_deleted"];
        $this->is_activated = $arr["is_activated"];
        $this->created_timestamp_spec = new DateSpecification($arr["created_timestamp_spec"]);
        $this->last_updated_timestamp_spec = new DateSpecification($arr["last_updated_timestamp_spec"]);
        $this->isAnd = $arr["isAnd"];
    }
}


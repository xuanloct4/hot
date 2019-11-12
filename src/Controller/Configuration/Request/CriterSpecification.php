<?php

namespace Src\Controller\Configuration\Request;


class CriterSpecification {
    public $list;
    public $isAnd = true;
    public $isOr = false;

    public function __construct($arr)
    {
        $this->list = $arr["list"];
        if ($arr["isAnd"]) {
            $this->isAnd = $arr["isAnd"];
        }
        if ($arr["isOr"]) {
            $this->isOr = $arr["isOr"];
        }
    }
}

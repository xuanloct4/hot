<?php

namespace Src\Controller\Configuration\Request;


class CriterSpecification
{
    public $list;
    public $isAnd = true;

    public function __construct($arr)
    {
        $this->list = $arr["list"];
        $this->isAnd = $arr["isAnd"];
    }
}

<?php

namespace Src\Controller\Configuration\Request;


class DateSpecification
{
    public $start;
    public $end;

    public function __construct($arr)
    {
        $this->start = $arr["start"];
        $this->end = $arr["end"];
    }
}

<?php


namespace Src\Controller\Configuration\Request;


class OrderSpecification
{
    public $column;
    public $isAscending= true;

    public function __construct($column, $isAscending=true)
    {
        $this->column = $column;
        $this->isAscending = $isAscending;
    }
}

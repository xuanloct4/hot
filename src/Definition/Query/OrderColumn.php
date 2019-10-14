<?php

namespace Src\Definition\Query;


class OrderColumn
{
public $column;
public $isAscending;

    public function __construct($column, $isAscending=Comparison::ascending)
    {
        $this->column = $column;
        $this->isAscending = $isAscending;
    }
}
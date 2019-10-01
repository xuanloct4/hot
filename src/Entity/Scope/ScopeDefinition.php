<?php

namespace Src\Entity\Scope;

class ScopeDefinition
{
    // table name
    public static $table_name = "scope_definition";

    // table columns
    public $id;
    public $level;
    public $order;
    public $actions;
    public $description;

    public function __construct()
    {

    }
}

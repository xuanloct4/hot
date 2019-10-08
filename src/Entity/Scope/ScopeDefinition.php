<?php

namespace Src\Entity\Scope;

use Src\Entity\Entity;

class ScopeDefinition extends Entity
{
    // table name
    public static function table()
    {
        return "scope_definition";
    }
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

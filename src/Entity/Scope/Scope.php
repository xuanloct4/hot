<?php

namespace Src\Entity\Scope;

class Scope
{
    // table name
    public static $table_name = "scope";

    // table columns
    public $id;
    public $scope_pair;
    public $description;

    public function __construct()
    {

    }
}

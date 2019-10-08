<?php

namespace Src\Entity\Scope;

use Src\Entity\Entity;

class Scope extends Entity
{
    // table name
    public static function table()
    {
        return "scope";
    }
    // table columns
    public $id;
    public $scope_pair;
    public $description;

    public function __construct()
    {

    }
}

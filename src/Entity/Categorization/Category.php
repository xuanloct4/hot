<?php

namespace Src\Entity\Categorization;

use Src\Entity\Entity;

class Category extends Entity
{
    // table name
    public static function table()
    {
        return "category";
    }
    // table columns
    public $id;
    public $name;
    public $description;
    public $map;
    public $statistics;

    public function __construct()
    {

    }
}

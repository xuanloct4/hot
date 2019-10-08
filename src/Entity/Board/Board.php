<?php

namespace Src\Entity\Board;

use Src\Entity\Entity;

class Board extends Entity
{
    // table name
    public static function table()
    {
        return "board";
    }
    // table columns
    public $id;
    public $name;
    public $description;
    public $model;
    public $manufacturer;
    public $version;
    public $firmware;
    public $os;
    public $image;
    public $sensors;
    public $boards;
    public $public_contacts;
    public $internal_contacts;
    public $is_deleted;
    public $is_activated;

    public function __construct()
    {

    }
}

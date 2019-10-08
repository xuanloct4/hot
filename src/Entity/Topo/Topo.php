<?php

namespace Src\Entity\Topo;

use Src\Entity\Entity;

class Topo extends Entity
{
    // table name
    public static function table()
    {
        return "topo";
    }
    // table columns
    public $id;
    public $board_internal_contact;
    public $sensor_internal_contact;
    public $description;

    public function __construct()
    {

    }
}

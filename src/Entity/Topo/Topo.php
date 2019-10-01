<?php

namespace Src\Entity\Topo;

class Topo
{
    // table name
    public static $table_name = "topo";

    // table columns
    public $id;
    public $board_internal_contact;
    public $sensor_internal_contact;
    public $description;

    public function __construct()
    {

    }
}

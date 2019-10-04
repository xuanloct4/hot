<?php

namespace Src\Entity\Board;

class Board
{
    // table name
    public static $table_name = "board";

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
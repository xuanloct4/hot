<?php

namespace Src\Entity\User;


use Src\Entity\Entity;

class Device extends Entity
{
    // table name
    public static function table()
    {
        return "device";
    }

    // table columns
    public $id;
    public $model;
    public $manufacturer;
    public $version;
    public $os;
    public $firmware;
    public $image;
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public function __construct()
    {

    }
}
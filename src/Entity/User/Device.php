<?php

namespace Src\Entity\User;


class Device
{
    // table name
    public static $table_name = "device";

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
<?php

namespace Src\Entity\Sensor;

class Sensor
{
    // table name
    public static $table_name = "sensor";

    // table columns
    public $id;
    public $name;
    public $description;
    public $model;
    public $manufacturer;
    public $version;
    public $firmware;
    public $image;
    public $public_contacts;
    public $internal_contacts;

    public function __construct()
    {

    }
}

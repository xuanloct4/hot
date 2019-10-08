<?php

namespace Src\Entity\Sensor;

use Src\Entity\Entity;

class Sensor extends Entity
{
    // table name
    public static function table()
    {
        return "sensor";
    }
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

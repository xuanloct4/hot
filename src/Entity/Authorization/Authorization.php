<?php

namespace Src\Entity\Authorization;

use Src\Entity\Entity;

class Authorization extends Entity
{
    // table name
    public static function table()
    {
        return "authorization";
    }

    // table columns
    public $id;
    public $name;
    public $uuid;
    public $authorized_code;
    public $tokens;
    public $created_timestamp;
    public $last_updated_timestamp;
    public $expired_interval;

    public function __construct()
    {

    }
}

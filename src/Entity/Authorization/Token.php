<?php

namespace Src\Entity\Authorization;

use Src\Entity\Entity;

class Token extends Entity
{
    // table name
    public static function table()
    {
        return "token";
    }

    // table columns
    public $id;
    public $authorized_id;
    public $token;
    public $created_timestamp;
    public $expired_interval;

    public function __construct()
    {

    }
}
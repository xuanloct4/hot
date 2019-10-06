<?php

namespace Src\Entity\Authorization;


class Token
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
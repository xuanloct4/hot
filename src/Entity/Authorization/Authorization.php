<?php

namespace Src\Entity\Authorization;

class Authorization
{
    // table name
    public static $table_name = "authorization";

    // table columns
    public $id;
    public $name;
    public $uuid;
    public $authorized_code;
    public $token;
    public $created_timestamp;
    public $last_updated_timestamp;
    public $expired_interval;

    public function __construct()
    {

    }
}

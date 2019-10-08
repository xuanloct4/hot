<?php

namespace Src\Entity\Log;

use Src\Entity\Entity;

class Log extends Entity
{
    // table name
    public static function table()
    {
        return "log";
    }

    // table columns
    public $id;
    public $content;
    public $configuration;
    public $type;
    public $level;
    public $scopes;
    public $created_timestamp;
    public $last_updated_timestamp;

    public function __construct()
    {

    }
}

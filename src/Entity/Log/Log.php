<?php

namespace Src\Entity\Log;

class Log
{
    // table name
    public static $table_name = "log";

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

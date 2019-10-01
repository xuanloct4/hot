<?php

namespace Src\Entity\Configuration;

class Configuration
{
    // table name
    public static $table_name = "configuration";

    // table columns
    public $id;

    public $files;
    public $uris;
    public $binary;
    public $strings;
    public $update_order;
    public $type;
    public $scopes;
    public $is_deleted;
    public $is_activated;
    public $created_timestamp;
    public $last_updated_timestamp;

    public function __construct()
    {

    }
}

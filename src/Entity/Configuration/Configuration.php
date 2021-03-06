<?php

namespace Src\Entity\Configuration;

use Src\Entity\Entity;

class Configuration extends Entity
{
    // table name
    public static function table()
    {
        return "configuration";
    }

    // table columns
    public $id;

    public $files;
    public $uris;
    public $binary;
    public $strings;
    public $update_order;
    public $type;
    public $scopes;
    public $category;
    public $is_deleted;
    public $is_activated;
    public $created_timestamp;
    public $last_updated_timestamp;

    public function __construct()
    {

    }
}

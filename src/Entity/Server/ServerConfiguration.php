<?php

namespace Src\Entity\Server;

use Src\Entity\Entity;

class ServerConfiguration extends Entity
{
    // table name
    public static function table()
    {
        return "server_configuration";
    }
    // table columns
    public $id;
    public $name;
    public $description;
    public $status;
    public $authorized_id;
    public $configuration;
    public $scopes;
    public $is_deleted;
    public $is_activated;
    public $created_timestamp;
    public $last_updated_timestamp;

    public function __construct()
    {

    }
}

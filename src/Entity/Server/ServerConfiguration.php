<?php

namespace Src\Entity\Server;

class ServerConfiguration
{
    // table name
    public static $table_name = "server_configuration";

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

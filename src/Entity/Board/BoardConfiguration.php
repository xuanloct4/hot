<?php

namespace Src\Entity\Board;

class BoardConfiguration
{
    // table name
    public static $table_name = "board_configuration";

    // table columns
    public $id;
    public $board_id;
    public $server_configuration_id;
    public $user_device_id;
    public $user_id;
    public $topos;
    public $status;
    public $authorized_id;
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;
    public $created_timestamp;
    public $last_updated_timestamp;

    public function __construct()
    {

    }
}

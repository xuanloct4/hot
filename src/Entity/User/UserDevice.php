<?php

namespace Src\Entity\User;

use Src\Entity\Entity;

class UserDevice extends Entity
{
    // table name
    public static function table()
    {
        return "user_device";
    }

    // table columns
    public $id;
    public $name;
    public $description;
    public $model;
    public $manufacturer;
    public $version;
    public $os;
    public $firmware;
    public $user_id;
    public $board_id;
    public $status;
    public $authorized_id;
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;
    public $created_timestamp;
    public $last_updated_timestamp;
    public $push_registration_token;

    public function __construct()
    {

    }
}

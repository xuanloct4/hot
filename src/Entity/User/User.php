<?php

namespace Src\Entity\User;

use Src\Entity\Entity;

class User extends Entity
{
    // table name
    public static function table()
    {
        return "user";
    }

    // table columns
    public $id;
    public $name;
    public $address;
    public $location;
    public $phone;
    public $gender;
    public $status;
    public $authorized_id;
    public $preferences;
    public $scopes;
    public $user_device_id;
    public $board_id;
    public $is_activated;
    public $is_deleted;
    public $created_timestamp;
    public $last_updated_timestamp;

    public function __construct()
    {

    }
}

<?php

namespace Src\Entity\User;

class User
{
    // table name
    public static $table_name = "user";

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
    public $is_activated;
    public $is_deleted;
    public $created_timestamp;
    public $last_updated_timestamp;

    public function __construct()
    {

    }
}

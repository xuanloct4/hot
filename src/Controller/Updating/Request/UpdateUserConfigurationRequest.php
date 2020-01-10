<?php

namespace Src\Controller\Updating\Request;


use Src\Controller\Request;

class UpdateUserConfigurationRequest extends Request
{
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

    public function __construct($arr)
    {
        $this->id = $arr["id"];
        $this->name = $arr["name"];
        $this->address = $arr["address"];
        $this->location = $arr["location"];
        $this->phone = $arr["phone"];
        $this->gender = $arr["gender"];
        $this->status = $arr["status"];
        $this->authorized_id = $arr["authorized_id"];
        $this->preferences = $arr["preferences"];
        $this->scopes = $arr["scopes"];
        //        if ($arr["is_deleted"] != null) {
        if ($arr["is_deleted"]) {
            $this->is_deleted = 1;
        } else {
            $this->is_deleted = 0;
        }
//        }

//        if ($arr["is_activated"] != null) {
        if ($arr["is_activated"]) {
            $this->is_activated = 1;
        } else {
            $this->is_activated = 0;
        }
//        }
    }
}

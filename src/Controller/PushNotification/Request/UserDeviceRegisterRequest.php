<?php

namespace Src\Controller\PushNotification\Request;


use Src\Controller\Request;

class UserDeviceRegisterRequest extends Request
{
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
//    public $status;
//    public $configuration;
//    public $is_activated;
//    public $is_deleted;
    public $push_registration_token;

    public function __construct($arr)
    {
        $this->id = $arr["id"];
        $this->name = $arr["name"];
        $this->description = $arr["description"];
        $this->model = $arr["model"];
        $this->manufacturer = $arr["manufacturer"];
        $this->version = $arr["version"];
        $this->os = $arr["os"];
        $this->firmware = $arr["firmware"];
//        $this->user_id = $arr["user_id"];
//        $this->board_id = $arr["board_id"];
//        $this->status = $arr["status"];
//        $this->configuration = $arr["configuration"];
//        $this->is_activated = $arr["is_activated"];
//        $this->is_deleted = $arr["is_deleted"];
        $this->push_registration_token = $arr["push_registration_token"];
    }
}

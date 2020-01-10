<?php

namespace Src\Controller\Creating\Request;


use Src\Controller\Request;

class CreateUserDeviceConfiguationRequest extends Request
{
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
    public $reference_device;
//    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public function __construct($arr)
    {
        $this->name = $arr["name"];
        $this->description = $arr["description"];
        $this->model = $arr["model"];
        $this->manufacturer = $arr["manufacturer"];
        $this->version = $arr["version"];
        $this->os = $arr["os"];
        $this->firmware = $arr["firmware"];
        $this->user_id = $arr["user_id"];
        $this->board_id = $arr["board_id"];
        $this->status = $arr["status"];
        $this->authorized_id = $arr["authorized_id"];
        $this->reference_device = $arr["reference_device"];
//        $this->configuration = $arr["configuration"];
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

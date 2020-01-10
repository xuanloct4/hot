<?php

namespace Src\Controller\Updating\Request;


use Src\Controller\Request;

class UpdateServerConfigurationRequest extends Request
{
    public $id;
    public $name;
    public $description;
    public $status;
    public $authorized_id;
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public function __construct($arr)
    {
        $this->id = $arr["id"];
        $this->name = $arr["name"];
        $this->description = $arr["description"];
        $this->status = $arr["status"];
        $this->authorized_id = $arr["authorized_id"];
        $this->configuration = $arr["configuration"];
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

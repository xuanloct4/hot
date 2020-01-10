<?php

namespace Src\Controller\Creating\Request;


use Src\Controller\Request;

class CreateServerConfigurationRequest extends Request
{
    public $name;
    public $description;
    public $status;
    public $authorized_id;
//    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public function __construct($arr)
    {
        $this->name = $arr["name"];
        $this->description = $arr["description"];
        $this->status = $arr["status"];
        $this->authorized_id = $arr["authorized_id"];
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


        $this->ref_1 = $arr["ref_1"];
        $this->ref_2 = $arr["ref_2"];
        $this->ref_3 = $arr["ref_3"];
        $this->ref_4 = $arr["ref_4"];
        $this->ref_5 = $arr["ref_5"];
        $this->ref_6 = $arr["ref_6"];
        $this->ref_7 = $arr["ref_7"];
        $this->ref_8 = $arr["ref_8"];
        $this->ref_9 = $arr["ref_9"];
        $this->ref_10 = $arr["ref_10"];
    }
}

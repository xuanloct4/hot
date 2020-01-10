<?php

namespace Src\Controller\Deleting\Request;


use Src\Controller\Request;

class DeleteConfigurationRequest extends Request
{
    public $id;
    public $uuid;

    public $ref_1;
    public $ref_2;
    public $ref_3;
    public $ref_4;
    public $ref_5;
    public $ref_6;
    public $ref_7;
    public $ref_8;
    public $ref_9;
    public $ref_10;

    public function __construct($arr)
    {
        $this->id = $arr["id"];
        $this->uuid = $arr["uuid"];

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

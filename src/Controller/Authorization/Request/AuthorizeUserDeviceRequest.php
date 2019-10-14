<?php

namespace Src\Controller\Authorization\Request;


use Src\Controller\Request;

class AuthorizeUserDeviceRequest extends Request
{
    public $device_id;
    public $authorized_code;

    public function __construct($arr)
    {
        $this->device_id = $arr["device_id"];
        $this->authorized_code = $arr["authorized_code"];
    }
}
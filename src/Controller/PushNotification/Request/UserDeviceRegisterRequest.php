<?php

namespace Src\Controller\PushNotification\Request;


use Src\Controller\Request;

class UserDeviceRegisterRequest extends Request
{
    public $device_token;

    public function __construct($arr)
    {
        $this->device_token = $arr["device_token"];
    }
}

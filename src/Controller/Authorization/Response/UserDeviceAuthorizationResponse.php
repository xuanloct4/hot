<?php

namespace Src\Controller\Authorization\Response;


use Src\Controller\Response;

class UserDeviceAuthorizationResponse extends Response
{
    public $token;
    public $expired_interval;
}
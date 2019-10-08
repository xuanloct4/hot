<?php

namespace Src\Controller\Authorization\Response;


class UserDeviceAuthorizationResponse extends Response
{
    public $token;
    public $expired_interval;
}
<?php

namespace Src\Controller\Authorization\Response;


use Src\Controller\Response;

class UserAuthorizationResponse extends Response
{
    public $token;
    public $expired_interval;
}
<?php

namespace Src\Controller\Authorization\Response;


class UserAuthorizationResponse extends Response
{
    public $token;
    public $expired_interval;
}
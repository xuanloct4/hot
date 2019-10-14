<?php

namespace Src\Controller\Authorization\Request;


use Src\Controller\Request;

class AuthorizeUserRequest extends Request
{
    public $uuid;
    public $authorized_code;

    public function __construct($arr)
    {
        $this->uuid = $arr["uuid"];
        $this->authorized_code = $arr["authorized_code"];
    }
}
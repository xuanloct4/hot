<?php

namespace Src\Controller\PushNotification\Response;


use Src\Controller\Response;
use Src\Entity\Board\Board;

class RegisterResponse extends Response
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}

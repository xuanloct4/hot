<?php

namespace Src\Controller\Creating\Response;


use Src\Controller\Response;

class CreateConfigurationResponse extends Response
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}

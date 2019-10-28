<?php

namespace Src\Controller\Deleting\Request;


use Src\Controller\Request;

class DeleteConfigurationRequest extends Request
{
    public $id;
    public $uuid;

    public function __construct($arr)
    {
        $this->id = $arr["id"];
        $this->uuid = $arr["uuid"];
    }
}

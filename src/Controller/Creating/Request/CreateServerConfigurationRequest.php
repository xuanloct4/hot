<?php

namespace Src\Controller\Creating\Request;


use Src\Controller\Request;

class CreateServerConfigurationRequest extends Request
{
    public $name;
    public $description;
    public $status;
    public $authorized_id;
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public function __construct($arr)
    {
        $this->name = $arr["name"];
        $this->description = $arr["description"];
        $this->status = $arr["status"];
        $this->authorized_id = $arr["authorized_id"];
        $this->configuration = $arr["configuration"];
        $this->scopes = $arr["scopes"];
        $this->is_activated = b'0';
        $this->is_deleted = b'0';
    }
}

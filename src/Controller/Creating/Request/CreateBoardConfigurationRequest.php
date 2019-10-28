<?php

namespace Src\Controller\Creating\Request;


use Src\Controller\Request;

class CreateBoardConfigurationRequest extends Request
{
    public $board_id;
    public $server_configuration_id;
    public $user_device_id;
    public $user_id;
    public $topos;
    public $status;
    public $authorized_id;
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public function __construct($arr)
    {
        $this->board_id = $arr["board_id"];
        $this->server_configuration_id = $arr["server_configuration_id"];
        $this->user_device_id = $arr["user_device_id"];
        $this->user_id = $arr["user_id"];
        $this->topos = $arr["topos"];
        $this->status = $arr["status"];
        $this->authorized_id = $arr["authorized_id"];
        $this->configuration = $arr["configuration"];
        $this->scopes = $arr["scopes"];
        $this->is_activated = b'0';
        $this->is_deleted = b'0';
    }
}

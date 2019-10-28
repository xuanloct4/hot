<?php

namespace Src\Controller\Updating\Request;


use Src\Controller\Request;

class UpdateUserDeviceConfiguationRequest extends Request
{
    public $id;
    public $name;
    public $description;
    public $model;
    public $manufacturer;
    public $version;
    public $os;
    public $firmware;
    public $user_id;
    public $status;
    public $authorized_id;
    public $reference_device;
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public function __construct($arr)
    {
        $this->id = $arr["id"];
        $this->name = $arr["name"];
        $this->description = $arr["description"];
        $this->model = $arr["model"];
        $this->manufacturer = $arr["manufacturer"];
        $this->version = $arr["version"];
        $this->os = $arr["os"];
        $this->firmware = $arr["firmware"];
        $this->user_id = $arr["user_id"];
        $this->status = $arr["status"];
        $this->authorized_id = $arr["authorized_id"];
        $this->reference_device = $arr["reference_device"];
        $this->configuration = $arr["configuration"];
        $this->scopes = $arr["scopes"];
    }
}

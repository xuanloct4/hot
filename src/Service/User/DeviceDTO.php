<?php

namespace Src\Service\User;


use Src\Entity\User\Device;

class DeviceDTO
{
    public $id;
    public $model;
    public $manufacturer;
    public $version;
    public $os;
    public $firmware;
    public $image;
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public function __construct(Device $token)
    {
        $this->id = $token->id;
        $this->model = $token->model;
        $this->manufacturer = $token->manufacturer;
        $this->version = $token->version;
        $this->os = $token->os;
        $this->firmware = $token->firmware;
        $this->image = $token->image;
        $this->configuration = $token->configuration;
        $this->scopes = $token->scopes;
        $this->is_activated = $token->is_activated;
        $this->is_deleted = $token->is_deleted;
    }
}

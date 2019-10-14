<?php

namespace Src\Controller\Activation\Response;


use Src\Controller\Response;
use Src\Entity\User\Device;
use Src\Utils\DateTimeUtils;

class DeviceConfigurationResponse extends Response
{
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public $servertime;

    public function __construct(Device $device)
    {
        $this->scopes = $device->scopes;
        $this->is_activated = $device->is_activated;
        $this->is_deleted = $device->is_deleted;

        $this->servertime = DateTimeUtils::getCurrentTimeString();
    }
}

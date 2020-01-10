<?php

namespace Src\Controller\Activation\Response;


use Src\Controller\Response;
use Src\Entity\User\Device;
use Src\Service\User\UserDTO;
use Src\Utils\DateTimeUtils;

class UserResponse extends Response
{
    public $configuration;
    public $scopes;
    public $is_activated;
    public $is_deleted;

    public $servertime;

    public function __construct(UserDTO $userDTO)
    {
        $this->scopes = $userDTO->scopes;
        $this->is_activated = $userDTO->is_activated;
        $this->is_deleted = $userDTO->is_deleted;

        $this->servertime = DateTimeUtils::getCurrentTimeString();
    }
}

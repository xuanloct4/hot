<?php

namespace Src\Controller\Configuration\Response;

use Src\Controller\Response;
use Src\Entity\Board\BoardConfiguration;
use Src\Entity\User\User;
use Src\Utils\DateTimeUtils;

class UserConfigurationResponse extends Response
{
    public $id;
    public $name;
    public $address;
    public $location;
    public $phone;
    public $gender;
    public $status;
//    public $authorized_id;
    public $preferences;
//    public $scopes;
    public $is_activated;
    public $is_deleted;
    public $created_timestamp;
    public $last_updated_timestamp;

    public $servertime;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->address = $user->address;
        $this->location = $user->location;
        $this->phone = $user->phone;
        $this->gender = $user->gender;
        $this->status = $user->status;
//        $this->authorized_id = $user->authorized_id;
//        $this->preferences = $user->preferences;
//        $this->scopes = $user->scopes;
        $this->is_activated = $user->is_activated;
        $this->is_deleted = $user->is_deleted;
        $this->created_timestamp = $user->created_timestamp;
        $this->last_updated_timestamp = $user->last_updated_timestamp;

        $this->servertime = DateTimeUtils::getCurrentTimeString();
    }
}

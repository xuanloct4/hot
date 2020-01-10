<?php
    namespace Src\Controller\Configuration\Response;

    use Src\Controller\Response;
    use Src\Entity\Board\BoardConfiguration;
    use Src\Entity\User\User;
    use Src\Entity\User\UserDevice;
    use Src\Utils\DateTimeUtils;

    class UserDeviceConfigurationResponse extends Response
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
//        public $authorized_id;
        public $configuration;
//        public $scopes;
        public $is_activated;
        public $is_deleted;
        public $created_timestamp;
        public $last_updated_timestamp;
//        public $push_registration_token;

        public $servertime;

        public function __construct(UserDevice $userDevice)
        {
            $this->id = $userDevice->id;
            $this->name = $userDevice->name;
            $this->description = $userDevice->description;
            $this->model = $userDevice->model;
            $this->manufacturer = $userDevice->manufacturer;
            $this->version = $userDevice->version;
            $this->os = $userDevice->os;
            $this->firmware = $userDevice->firmware;
            $this->user_id = $userDevice->user_id;
            $this->status = $userDevice->status;
//            $this->authorized_id = $userDevice->authorized_id;
//            $this->configuration = $userDevice->configuration;
//            $this->scopes = $userDevice->scopes;
            $this->is_activated = $userDevice->is_activated;
            $this->is_deleted = $userDevice->is_deleted;
            $this->created_timestamp = $userDevice->created_timestamp;
            $this->last_updated_timestamp = $userDevice->last_updated_timestamp;
//            $this->push_registration_token = $userDevice->push_registration_token;

            $this->servertime = DateTimeUtils::getCurrentTimeString();
        }
    }

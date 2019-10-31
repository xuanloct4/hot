<?php
    namespace Src\Controller\Configuration\Response;

    use Src\Controller\Response;
    use Src\Entity\Board\BoardConfiguration;
    use Src\Utils\DateTimeUtils;

    class BoardConfigurationResponse extends Response
    {
        public $server_configuration_id;
        public $user_device_id;
        public $user_id;
        public $topos;
        public $status;
//        public $authorized_id;
        public $configuration;
//        public $scopes;
        public $is_activated;
        public $is_deleted;
        public $created_timestamp;
        public $last_updated_timestamp;

        public $servertime;

        public function __construct(BoardConfiguration $boardConfiguration)
        {
            $this->server_configuration_id = $boardConfiguration->server_configuration_id;
            $this->user_device_id = $boardConfiguration->user_device_id;
            $this->user_id = $boardConfiguration->user_id;
            $this->topos = $boardConfiguration->topos;
            $this->status = $boardConfiguration->status;
//            $this->configuration = $boardConfiguration->configuration;
            $this->is_activated = $boardConfiguration->is_activated;
            $this->is_deleted = $boardConfiguration->is_deleted;
            $this->created_timestamp = $boardConfiguration->created_timestamp;
            $this->last_updated_timestamp = $boardConfiguration->last_updated_timestamp;

            $this->servertime = DateTimeUtils::getCurrentTimeString();
        }
    }

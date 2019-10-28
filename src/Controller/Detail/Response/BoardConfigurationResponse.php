<?php
    namespace Src\Controller\Profile\Response;

    use Src\Controller\Request;
    use Src\Controller\Response;
    use Src\Entity\Board\BoardConfiguration;
    use Src\Utils\DateTimeUtils;

    class BoardConfigurationResponse extends Response {
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

        public function __construct(BoardConfiguration $boardConfiguration)
        {
            $this->board_id = $boardConfiguration->board_id;
            $this->server_configuration_id = $boardConfiguration->server_configuration_id;
            $this->user_device_id = $boardConfiguration->user_device_id;
            $this->user_id = $boardConfiguration->user_id;
            $this->topos = $boardConfiguration->topos;
            $this->status = $boardConfiguration->status;
            $this->authorized_id = $boardConfiguration->authorized_id;
            $this->configuration = $boardConfiguration->configuration;
            $this->scopes = $boardConfiguration->scopes;
            $this->is_activated = b'0';
            $this->is_deleted = b'0';
        }
    }

<?php
    namespace Src\Controller\Configuration\Response;

    use Src\Controller\Response;
    use Src\Entity\Board\BoardConfiguration;
    use Src\Entity\Server\ServerConfiguration;
    use Src\Entity\User\User;
    use Src\Utils\DateTimeUtils;

    class ServerConfigurationResponse extends Response
    {
        public $name;
        public $description;
        public $status;
//        public $authorized_id;
        public $configuration;
//        public $scopes;
        public $is_deleted;
        public $is_activated;
        public $created_timestamp;
        public $last_updated_timestamp;

        public $servertime;

        public function __construct(ServerConfiguration $serverConfiguration)
        {
            $this->name = $serverConfiguration->name;
            $this->description = $serverConfiguration->description;
            $this->status = $serverConfiguration->status;
//            $this->authorized_id = $serverConfiguration->authorized_id;
//            $this->configuration = $serverConfiguration->configuration;
//            $this->scopes = $serverConfiguration->scopes;
            $this->is_activated = $serverConfiguration->is_activated;
            $this->is_deleted = $serverConfiguration->is_deleted;
            $this->created_timestamp = $serverConfiguration->created_timestamp;
            $this->last_updated_timestamp = $serverConfiguration->last_updated_timestamp;

            $this->servertime = DateTimeUtils::getCurrentTimeString();
        }
    }

<?php
    namespace Src\Controller\Authorization\Response;

    use Src\Controller\Response;
    use Src\Entity\Board\BoardConfiguration;
    use Src\Utils\DateTimeUtils;

    class BoardAuthorizationResponse extends Response
    {
        public $token;
        public $expired_interval;
        public $number_of_valid_access;

        public function __construct()
        {
//            $this->servertime = DateTimeUtils::getCurrentTimeString();
        }
    }

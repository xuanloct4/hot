<?php
    namespace Src\Controller\Authorization\Response;
    
    use Src\Entity\Board\BoardConfiguration;
    use Src\Utils\DateTimeUtils;

    class BoardAuthorizationResponse extends Response{
        public $token;
        public $expired_interval;

        public function __construct()
        {
//            $this->servertime = DateTimeUtils::getCurrentTime();
        }
    }
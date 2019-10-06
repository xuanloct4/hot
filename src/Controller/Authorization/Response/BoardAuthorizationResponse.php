<?php
    namespace Src\Controller\Authorization\Response;
    
    use Src\Entity\Board\BoardConfiguration;
    use Src\Utils\DateTimeUtils;

    class BoardAuthorizationResponse {
        public $token;
        public $expired_interval;

        public function __construct(BoardConfiguration $boardConfiguration)
        {
//            $this->servertime = DateTimeUtils::getCurrentTime();
        }
    }
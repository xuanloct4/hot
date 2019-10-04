<?php
    namespace Src\Controller\Activation\Request;

    class ActivateBoardConfigurationRequest {
        public $board_id;
        public $authorized_code;

        public function __construct($arr)
        {
            $this->board_id = $arr["board_id"];
            $this->authorized_code = $arr["authorized_code"];
        }
    }
<?php
    namespace Src\Controller\Activation\Request;

    use Src\Controller\Request;

    class ActivateBoardConfigurationRequest extends Request {
        public $board_id;
        public $authorized_code;

        public function __construct($arr)
        {
            $this->board_id = $arr["board_id"];
            $this->authorized_code = $arr["authorized_code"];
        }
    }
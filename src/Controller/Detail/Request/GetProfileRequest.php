<?php
    namespace Src\Controller\Detail\Request;

    use Src\Controller\Request;

    class GetProfileRequest extends Request {
        public $id;
        public $uuid;

        public function __construct($arr)
        {
            $this->id = $arr["id"];
            $this->uuid = $arr["uuid"];
        }
    }

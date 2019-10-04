<?php
    namespace Src\Controller\Activation\Request;


    class ActivateDeviceConfigurationRequest {
        public $os;
        public $model;

        public function __construct($arr)
        {
            $this->os = $arr["os"];
            $this->model = $arr["model"];
        }
    }

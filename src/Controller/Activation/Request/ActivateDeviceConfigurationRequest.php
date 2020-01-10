<?php
    namespace Src\Controller\Activation\Request;


    use Src\Controller\Request;

    class ActivateDeviceConfigurationRequest extends Request {
        public $os;
        public $model;
        public $manufacturer;
        public $version;
        public $firmware;
        public $image;

        public function __construct($arr)
        {
            $this->os = $arr["os"];
            $this->model = $arr["model"];
            $this->manufacturer = $arr["manufacturer"];
            $this->version = $arr["version"];
            $this->firmware = $arr["firmware"];
            $this->image = $arr["image"];
        }
    }

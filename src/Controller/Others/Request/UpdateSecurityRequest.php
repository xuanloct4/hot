<?php
    namespace Src\Controller\Others\Request;

    use Src\Controller\Request;

    class UpdateSecurityRequest extends Request {
        public $uuid;
        public $reference1;
        public $reference2;
        public $reference3;
        public $reference4; 
        public $reference5;
        public $reference6;
        public $reference7;
        public $reference8;
        public $reference9;
        public $reference10;
        
        public function __construct($arr)
        {
            $this->uuid = $arr["uuid"];
            $this->reference1 = $arr["reference1"];
            $this->reference2 = $arr["reference2"];
            $this->reference3 = $arr["reference3"];
            $this->reference4 = $arr["reference4"];
            $this->reference5 = $arr["reference5"];
            $this->reference6 = $arr["reference6"];
            $this->reference7 = $arr["reference7"];
            $this->reference8 = $arr["reference8"];
            $this->reference9 = $arr["reference9"];
            $this->reference10 = $arr["reference10"];
        }
    }

<?php
    namespace Src\Controller\Configuration\Request;

    use Src\Controller\Request;

    class ConfigurationRequest extends Request
    {
        public $categories;
        public $page;

        public $startDate;
        public $endDate;

        public function __construct($arr)
        {

        }
    }

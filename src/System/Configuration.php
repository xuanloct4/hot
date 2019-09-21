<?php

namespace Src\System;

class Configuration
{
    private $db;
    private $baseAPIUrl;
    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here. = $dbConnection;
        $this->db = DatabaseConnector::getInstance()->getConnection();
        $this->baseAPIUrl = getenv('BASE_API_URL');
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Configuration();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->db;
    }

    public function getBaseAPIURL()
    {
        return $this->baseAPIUrl;
    }

    public function defaultHeader()
    {
        $headers = array("Access-Control-Allow-Origin: *",
            "Content-Type: application/json; charset=UTF-8",
            "Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE",
            "Access-Control-Max-Age: 3600",
            "Access-Control-Allow-Headers: Content-Type",
            "Access-Control-Allow-Headers, Authorization, X-Requested-With");
        return $headers;
    }
}

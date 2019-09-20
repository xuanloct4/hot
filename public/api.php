<?php

namespace Main;
require "../bootstrap.php";

use Src\System\DatabaseConnector;
use Src\Controller\PersonController;
use Src\Router\Router;

class Configuration
{
    private $db;

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here. = $dbConnection;
        $this->db = DatabaseConnector::getInstance()->getConnection();
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


foreach (Configuration::getInstance()->defaultHeader() as $value) {
    header($value);
}

// header('HTTP/1.1 200 OK');
// echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Get Request Method
$requestMethod = $_SERVER["REQUEST_METHOD"];
// Get Request Params from URL
$requestParams = array();
$queryString = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1]);
foreach ($queryString as $kv) {
    $kv = explode('=', $kv);
    $requestParams[$kv[0]] = $kv[1];
}
// Get Request Body
$requestBody = (array)json_decode(file_get_contents('php://input'), TRUE);
// Get Request Header
$requestHeaders = getallheaders();
// Get URI path and split components
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$baseAPIUrl = getenv('BASE_API_URL');
Router::getInstance()->processRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody);

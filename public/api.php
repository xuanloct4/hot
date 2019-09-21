<?php

namespace Main;
require "../bootstrap.php";

use Src\System\Configuration;
use Src\Router\Router;

foreach (Configuration::getInstance()->defaultHeader() as $value) {
    header($value);
}
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

Router::getInstance()->processRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody);

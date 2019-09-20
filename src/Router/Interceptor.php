<?php

namespace Src\Router;

class Interceptor
{
    private $uriComponents;
    private $requestHeaders;
    private $requestMethod;
    private $requestParams;
    private $requestBody;

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here. = $dbConnection;
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Interceptor();
        }

        return self::$instance;
    }


    public function init($uriComponents, $requestHeaders, $requestMethod, $requestParams, $requestBody)
    {
        $this->uriComponents = $uriComponents;
        $this->requestHeaders = $requestHeaders;
        $this->requestMethod = $requestMethod;
        $this->requestParams = $requestParams;
        $this->requestBody = $requestBody;
    }

    public function authorize()
    {
        // TO DO
        // Get and check the authorization and scope of the client
        return true;
    }

}
    
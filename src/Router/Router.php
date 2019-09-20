<?php
namespace Src\Router;
use Src\Controller\Controller;

class Router
{
    private static $patterns = array(
        "^((\/){1,}hot(\/){1,}public(\/){1,}api(.php){0,1}(\/){1,}person(\/)*(\w)*)" => "Src\Controller\PersonController",
        // "as"=> class API("^(\/hot\/public\/api(.php){0,1}\/person(\/)*(\w)*)","Src\Controller\PersonController"),
    );

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
            self::$instance = new Router();
        }

        return self::$instance;
    }


    public function getControllerForRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody)
    {
        // switch ($uri) {
// 			    case PersonController::$urlPattern:
// 			        echo "i égal 0";
// 			    case 1:
// 			        echo "i égal 1";
// 			    case 2:
// 			        echo "i égal 2";
// 			}
        $keys = array_keys(Router::$patterns);
        foreach ($keys as $key) {
            // var_dump($uri);
            // var_dump($key);
            $matches = array();
            preg_match("/{$key}/", $uri, $matches);
            // var_dump($matches);
            if (sizeof($matches) > 0) {
                $uriComponents = explode('/', $uri);
                // pass the request method and user ID to the PersonController and process the HTTP request:
                $class = Router::$patterns[$key];
                $controller = new $class();
                // $method = "echoArgOne";
                // $controller->$method();
                $controller->setURLPattern($key);
                $controller->setURIComponents($uriComponents);
                $controller->setRequestHeaders($requestHeaders);
                $controller->setRequestMethod($requestMethod);
                $controller->setRequestParams($requestParams);
                $controller->setRequestBody($requestBody);
                $controller->init();
                return $controller;
            }
        }

        return null;

    }

    public function processRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody)
    {
        Interceptor::getInstance()->init($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody);
        $isAuthorized = Interceptor::getInstance()->authorize();
        if ($isAuthorized) {
            $controller = $this->getControllerForRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody);
            if ($controller != null) {
                $controller->processRequest();
            }
        } else {
            Controller::respondNotFoundResponse();
        }
    }
}
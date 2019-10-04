<?php

namespace Src\Router;

use Src\Controller\Controller;
use Src\Definition\Comparison;
use Src\Definition\Constants;
use Src\Definition\DateTime;
use Src\Definition\ScopePair;
use Src\Service\URI\URIService;
use Src\Utils\Encryption\AES;
use Src\Utils\Encryption\RSA;
use Src\Utils\StringUtils;

class Router
{
//    private static $patterns = array(
//        "^((\/){1,}hot(\/){1,}public(\/){1,}api(.php){0,1}(\/){1,}person(\/)*(\w)*)" => "Src\Controller\PersonController",
//        // "as"=> class API("^(\/hot\/public\/api(.php){0,1}\/person(\/)*(\w)*)","Src\Controller\PersonController"),
//    );

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


    public function getControllerForRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody, $scopes)
    {
        $apis = URIService::getInstance()->findByType(Constants::API);
        foreach ($apis as $api) {
            $matches = array();
            preg_match("/{$api->representation}/", $uri, $matches);
            // var_dump($matches);
            if (sizeof($matches) > 0) {
                $apiScopes = StringUtils::getScopes($api->scopes);
                $clientScopes = StringUtils::getScopes($scopes);

                foreach ($apiScopes as $apiScope) {
                    foreach ($clientScopes as $clientScope) {
//                        var_dump($apiScope);
//                        var_dump($clientScope);
                        if (StringUtils::compareScope($clientScope, $apiScope) == Comparison::descending || StringUtils::compareScope($clientScope, $apiScope) == Comparison::equal) {
                            $uriComponents = explode('/', $uri);
                            array_filter($uriComponents);
                            $class = $api->content;
                            $controller = new $class();
                            // $method = "echoArgOne";
                            // $controller->$method();
                            $controller->setURLPattern($api->representation);
                            $controller->setURIComponents($uriComponents);
                            $controller->setRequestHeaders($requestHeaders);
                            $controller->setRequestMethod($requestMethod);
                            $controller->setRequestParams($requestParams);
                            $controller->setRequestBody($requestBody);
                            $controller->setScopes($clientScopes);
                            $controller->init();
                            return $controller;
                        }
                    }
                }
            }
        }

        return null;

    }

    public function processRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody)
    {
//        // Do this once then store it somehow:
//        $key = \Sodium\randombytes_buf(\Sodium\CRYPTO_SECRETBOX_KEYBYTES);
//        $message = 'We are all living in a yellow submarine';
//
//        $ciphertext = AES::safeEncrypt($message, $key);
//        $plaintext = AES::safeDecrypt($ciphertext, $key);
//        var_dump($ciphertext);
//        var_dump($plaintext);

        $interceptor = new Interceptor();
        $interceptor->authorize($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody);
        $controller = $this->getControllerForRequest($interceptor->uriComponents, $interceptor->requestHeaders, $interceptor->requestMethod, $interceptor->requestParams, $interceptor->requestBody, $interceptor->scopes);
        if ($controller != null) {
            $controller->processRequest();
        } else {
            Controller::respondNotFoundResponse();
        }
    }
}
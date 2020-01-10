<?php

namespace Src\Router;

use Src\Controller\Controller;
use Src\Definition\Comparison;
use Src\Definition\Constants;
use Src\Service\URI\URIService;
use Src\Utils\Encryption\RSA;
use Src\Utils\StringUtils;
use Src\Service\VoIPush\PushNotifications;

class Router
{
    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here. = $dbConnection;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Router();
        }

        return self::$instance;
    }


    public function getControllerForRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody, $scopes, $interceptData, $chanelId, $token, $authorization)
    {
        $apis = URIService::getInstance()->findByType(Constants::API);
        foreach ($apis as $api) {
//            var_dump($api);
            if (StringUtils::compareStringIgnoreCase($api->content, $requestMethod)) {
                $matches = array();
                preg_match("/{$api->representation}/", $uri, $matches);
//                var_dump($uri);
//                var_dump($api->representation);
//                var_dump($matches);
                if (sizeof($matches) > 0 && StringUtils::compareStringIgnoreCase($uri, $matches[0])) {
//                    var_dump($api);
                    $apiScopes = StringUtils::getScopes($api->scopes);
                    $clientScopes = StringUtils::getScopes($scopes);
//                    var_dump($apiScopes);
//                    var_dump($clientScopes);
                    foreach ($apiScopes as $apiScope) {
                        foreach ($clientScopes as $clientScope) {
                            if (StringUtils::compareScope($clientScope, $apiScope) == Comparison::descending || StringUtils::compareScope($clientScope, $apiScope) == Comparison::equal) {
                                $uriComponents = explode('/', $uri);
                                array_filter($uriComponents);
                                $class = $api->physical_address;
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
                                $controller->setInterceptData($interceptData);
                                $controller->setChanelId($chanelId);
                                $controller->setToken($token);
                                $controller->setAuthorization($authorization);

                                $controller->init();
                                return $controller;
                            }
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

//        $subject = new Subject();
//        $o1 = new Object();
//        $subject->attach($o1);
//        $subject->setState(1);
//        $subject->detach($o1);
//        $subject->setState(2);
//        var_dump(RSA::encrypt("abcdef"));
//        RSA::generateRSAKeyPair();

//        var_dump(RSA::encrypt("def"));
//        var_dump(RSA::decrypt("cHA0uS/yMNJRsPIt9/eX1Z44zJGDIbdXUJKKLf9DjntuWyAo/AXvqCMwGA3meFAsAWU+VJ3Dqito
//dyNU6j6aOuQaBxpaCgYdPBlSr0YDHsG50KsheazD9Gn9LEvLJizjrgIyefvqP1BAQFrq5vdQ6puw
//UPFk9eOLqZAtTU49qKoHSJrJ9Pgm992aQHJJA63RASQUXE+G+O27pk2eUkZGkshtrizc9cQwzFH2
//OF7I0etAnO/OgCaF5EIS3cv6EZZov4dOT2XaIng1/J2yyS6/EfX/x+Fo9+Z54ZoFOEB73MfeuaG6
//+x6Zg/qzW26JmJGNWcHku2PMm2FzHGj4leSh2wMKqjm/YB/y+UuQ9wUD9JR+kmYRugGQ6o6oibsP
//nQkj6lzjMKlYxhoWGVco6iUio40ISonIHl3z/iqcs/wgddjXMBV+xXKgvuZXzOG8XaUuBX3SiNpM
//CfTJLZ9R3kGAutKj6K06cp0C4vIFETrja/p3mXIfYcoCtt9qeEmGh0rniumBEjvOZIeDX6sc2KNs
//K1lw3GtxhtfQQSxw73TucuXaUkUO0nTYb4mMLkv/GK32zlacAMhNJedSSMbA02Q0KgeyTLcsLouB
//vibzqlZZaKzmocZqtG2JJrtNBgScGgGW75ZKuFNTS3jJvyiX7kjXB4TctkWc4fFPmurPMKh7JDk="));

        foreach ($requestHeaders as $name => $value) {
            if (strcmp($name, Constants::AccessType) == 0 &&
                (strcmp($value, AccessType::NOT_AUTHORIZED) == 0 ||
                    strcmp($value, AccessType::TRUSTED_AUTHORIZE) == 0)) {
                $interceptor = new InstantRouter();
                $interceptor->handleRequest($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody, $value);
                return;
            }
        }

        $interceptor = new Interceptor();
        $interceptor->authorize($uri, $requestHeaders, $requestMethod, $requestParams, $requestBody);
        $controller = $this->getControllerForRequest($interceptor->uriComponents, $interceptor->requestHeaders, $interceptor->requestMethod, $interceptor->requestParams, $interceptor->requestBody, $interceptor->scopes, $interceptor->interceptData, $interceptor->chanelId, $interceptor->token, $interceptor->authorization);
        if ($controller != null && method_exists($controller, "processRequest")) {
            $controller->processRequest();
        } else {
            Controller::respondNotFoundResponse();
        }
    }
}

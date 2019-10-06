<?php

namespace Src\Router;

use MyCLabs\Enum\Enum;
use Src\Definition\Comparison;
use Src\Definition\Configuration;
use Src\Definition\Constants;
use Src\Definition\ScopePair;
use Src\Service\Authorization\AuthorizationService;
use Src\Service\Authorization\TokenService;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;

class Interceptor
{
    public $uriComponents;
    public $requestHeaders;
    public $requestMethod;
    public $requestParams;
    public $requestBody;
    public $scopes;

//    // Hold the class instance.
//    private static $instance = null;
//
//    // The constructor is private
//    // to prevent initiation with outer code.
//    private function __construct()
//    {
//        // The expensive process (e.g.,db connection) goes here. = $dbConnection;
//    }
//
//    // The object is created from within the class itself
//    // only if the class has no instance.
//    public static function getInstance()
//    {
//        if (self::$instance == null) {
//            self::$instance = new Interceptor();
//        }
//
//        return self::$instance;
//    }


//    public function init($uriComponents, $requestHeaders, $requestMethod, $requestParams, $requestBody)
//    {
//        $this->uriComponents = $uriComponents;
//        $this->requestHeaders = $requestHeaders;
//        $this->requestMethod = $requestMethod;
//        $this->requestParams = $requestParams;
//        $this->requestBody = $requestBody;
//    }

    public function authorize($uriComponents, $requestHeaders, $requestMethod, $requestParams, $requestBody)
    {
        $this->uriComponents = $uriComponents;
        $this->requestHeaders = $requestHeaders;
        $this->requestMethod = $requestMethod;
        $this->requestParams = $requestParams;
        $this->requestBody = $requestBody;

        // Get and check the authorization and scope of the client
        // if the header contain authorization code
        // find user id with that code (check if the code is in expired_time) and check scope
        // else redirect to api with that path if api scope is (0,0,0,0)

        foreach ($requestHeaders as $name => $value) {
            if (strcasecmp($name, Constants::ChanelID) == 0) {
                $chanelId = $value;
            } else if (strcasecmp($name, Constants::Authorization) == 0) {
                $accessToken = $value;
            }
        }

        $this->scopes = "0,0,0,0";
        try {
            $token = TokenService::getInstance()->findFirstByToken($accessToken);
            if ($token != null) {
                $authorization = AuthorizationService::getInstance()->find($token->authorized_id);
                foreach ($authorization as $item) {
                    $auth_id = $item->id;
                    switch ($chanelId) {
                        case Configuration::BOARD:
                            $boardConfiguration = BoardConfigurationService::getInstance()->findByAuthID($auth_id);
                            if (sizeof($boardConfiguration) > 0) {
                                $this->requestHeaders[Constants::BoardID] = $boardConfiguration[0]->id;
                                $this->scopes = $boardConfiguration[0]->scopes;
                            }
                            break;
                        case Configuration::USER:
                            $userConfiguration = UserService::getInstance()->findByAuthID($auth_id);
                            if (sizeof($userConfiguration) > 0) {
                                $this->requestHeaders[Constants::UserID] = $userConfiguration[0]->id;
                                $this->scopes = $userConfiguration[0]->scopes;
                            }
                            break;
                        case Configuration::USER_DEVICE:
                            $userDeviceConfiguration = UserDeviceService::getInstance()->findByAuthID($auth_id);
                            if (sizeof($userDeviceConfiguration) > 0) {
                                $this->requestHeaders[Constants::UserDeviceID] = $userDeviceConfiguration[0]->id;
                                $this->scopes = $userDeviceConfiguration[0]->scopes;
                            }
                            break;
                        case Configuration::SERVER:
                            $serverConfiguration = ServerConfigurationService::getInstance()->findByAuthID($auth_id);
                            if (sizeof($serverConfiguration) > 0) {
                                $this->requestHeaders[Constants::ServerID] = $serverConfiguration[0]->id;
                                $this->scopes = $serverConfiguration[0]->scopes;
                            }
                            break;
                    }
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

//    private function updateScope($configurationScopes, $configuration) {
//        $scopeArrays = explode("|",$configurationScopes);
//        $expectedScope = "0";
//        foreach ($scopeArrays as $scopeArray) {
//            $scopes = explode(",",$scopeArray);
//            if (sizeof($scopes) > $configuration) {
//                if (StringUtils::compareVersion($expectedScope, $scopes[$configuration]) == Comparison::ascending) {
//                    $expectedScope = $scopes[$configuration];
//                }
//            }
//        }
//
//        $this->scope = ScopePair::updateScopeArray($this->scope, new ScopePair($expectedScope, $configuration));
//    }

}
    
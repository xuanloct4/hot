<?php

namespace Src\Router;

use Src\Definition\AccessType;
use Src\Definition\Comparison;
use Src\Definition\Configuration;
use Src\Definition\Constants;
use Src\Definition\Query\OrderColumn;
use Src\Service\Authorization\AuthorizationService;
use Src\Service\Authorization\TokenService;
use Src\Service\Board\BoardConfigurationService;
use Src\Service\Server\ServerConfigurationService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\ArrayUtils;
use Src\Utils\DateTimeUtils;
use Src\Utils\StringUtils;

class QEEE
{
    public $num;
    public $label;
    public $name;
    public function __construct($num, $label, $name)
    {
        $this->num = $num;
        $this->label = $label;
        $this->name = $name;
    }

}

class Interceptor
{
    public $uriComponents;
    public $requestHeaders;
    public $requestMethod;
    public $requestParams;
    public $requestBody;
    public $scopes;
    public $chanelId;
    public $interceptData;
    public $token;
    public $authorization;

    public function authorize($uriComponents, $requestHeaders, $requestMethod, $requestParams, $requestBody)
    {
//        $arr = array(new QEEE(3,"price","a"),
//            new QEEE(3,"quality","a"),
//            new QEEE(2,"milk","b"),
//            new QEEE(2,"milk","c"),
//            new QEEE(5,"pork","c"));
//        var_dump(ArrayUtils::sort($arr, array(new OrderColumn("num", Comparison::descending))));
//        var_dump($arr);


        $this->uriComponents = $uriComponents;
        $this->requestHeaders = $requestHeaders;
        $this->requestMethod = $requestMethod;
        $this->requestParams = $requestParams;
        $this->requestBody = $requestBody;

        // Get and check the authorization and scope of the client
        // if the header contain authorization code
        // find user id with that code (check if the code is in expired_time) and check scope
        // else redirect to api with that path if api scope is (0,0,0,0)

        $this->scopes = "0,0,0,0";
        $accessToken = null;
        $this->chanelId = -1;
        foreach ($requestHeaders as $name => $value) {
            if (StringUtils::compareStringIgnoreCase(strtolower($name), strtolower(Constants::ChanelID))) {
                $this->chanelId = $value;
            } else if (StringUtils::compareStringIgnoreCase(strtolower($name), strtolower(Constants::Authorization))) {
                $accessToken = $value;
            }
        }

        if ($accessToken != null) {
            try {
                $token = TokenService::getInstance()->findFirstByToken($accessToken);
                if ($token != null) {
                    $tokenDate = DateTimeUtils::convertStringToDateTimeDB($token->created_timestamp);
                    $currentDate = DateTimeUtils::getCurrentTime();
                    if ($tokenDate != false) {
                        $interval = $currentDate->getTimestamp() - $tokenDate->getTimestamp();
                        $expire = $token->expired_interval;
                        if ($expire == null || $expire < 0 || $interval < $expire) {
                            $authorization = AuthorizationService::getInstance()->find($token->authorized_id);
//                            var_dump($authorization);
                            foreach ($authorization as $item) {
                                $auth_id = $item->id;
                                switch ($this->chanelId) {
                                    case Configuration::BOARD:
                                        $boardConfiguration = BoardConfigurationService::getInstance()->findByAuthID($auth_id);
//                                        var_dump($boardConfiguration);
                                        if ($boardConfiguration != null) {
                                            $this->requestHeaders[Constants::BoardID] = $boardConfiguration->id;
                                            $this->scopes = $boardConfiguration->scopes;
                                            $this->interceptData = $boardConfiguration;
                                            $this->token = $token;
                                            $this->authorization = $item;
                                        }
                                        break;
                                    case Configuration::USER:
                                        $userConfiguration = UserService::getInstance()->findByAuthID($auth_id);
                                        if ($userConfiguration != null) {
                                            $this->requestHeaders[Constants::UserID] = $userConfiguration->id;
                                            $this->scopes = $userConfiguration->scopes;
                                            $this->interceptData = $userConfiguration;
                                            $this->token = $token;
                                            $this->authorization = $item;
                                        }
                                        break;
                                    case Configuration::USER_DEVICE:
                                        $userDeviceConfiguration = UserDeviceService::getInstance()->findByAuthID($auth_id);
                                        if ($userDeviceConfiguration != null) {
                                            $this->requestHeaders[Constants::UserDeviceID] = $userDeviceConfiguration->id;
                                            $this->scopes = $userDeviceConfiguration->scopes;
                                            $this->interceptData = $userDeviceConfiguration;
                                            $this->token = $token;
                                            $this->authorization = $item;
                                        }
                                        break;
                                    case Configuration::SERVER:
                                        $serverConfiguration = ServerConfigurationService::getInstance()->findByAuthID($auth_id);
                                        if ($serverConfiguration != null) {
                                            $this->requestHeaders[Constants::ServerID] = $serverConfiguration->id;
                                            $this->scopes = $serverConfiguration->scopes;
                                            $this->interceptData = $serverConfiguration;
                                            $this->token = $token;
                                            $this->authorization = $item;
                                        }
                                        break;
                                    default:
                                        echo "Unknown Error";
                                        break;
                                }
                            }
                        }
                    }
                }
            } catch (Exception $e) {
//                echo 'Caught exception: ', $e->getMessage(), "\n";
                echo "Unknown Error";
            }
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

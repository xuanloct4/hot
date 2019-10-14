<?php

namespace Src\Router;

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

    public function authorize($uriComponents, $requestHeaders, $requestMethod, $requestParams, $requestBody)
    {
        $arr = array(new QEEE(3,"price","a"),
            new QEEE(3,"quality","a"),
            new QEEE(2,"milk","b"),
            new QEEE(2,"milk","c"),
            new QEEE(5,"pork","c"));
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

        $accessToken = null;
        foreach ($requestHeaders as $name => $value) {
            if (strcmp($name, Constants::ChanelID) == 0) {
                $chanelId = $value;
            } else if (strcmp($name, Constants::Authorization) == 0) {
                $accessToken = $value;
            }
        }

        $this->scopes = "0,0,0,0";
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
                            foreach ($authorization as $item) {
                                $auth_id = $item->id;
                                switch ($chanelId) {
                                    case Configuration::BOARD:
                                        $boardConfiguration = BoardConfigurationService::getInstance()->findByAuthID($auth_id);
                                        if ($boardConfiguration != null) {
                                            $this->requestHeaders[Constants::BoardID] = $boardConfiguration->id;
                                            $this->scopes = $boardConfiguration->scopes;
                                        }
                                        break;
                                    case Configuration::USER:
                                        $userConfiguration = UserService::getInstance()->findByAuthID($auth_id);
                                        if ($userConfiguration != null) {
                                            $this->requestHeaders[Constants::UserID] = $userConfiguration->id;
                                            $this->scopes = $userConfiguration->scopes;
                                        }
                                        break;
                                    case Configuration::USER_DEVICE:
                                        $userDeviceConfiguration = UserDeviceService::getInstance()->findByAuthID($auth_id);
                                        if ($userDeviceConfiguration != null) {
                                            $this->requestHeaders[Constants::UserDeviceID] = $userDeviceConfiguration->id;
                                            $this->scopes = $userDeviceConfiguration->scopes;
                                        }
                                        break;
                                    case Configuration::SERVER:
                                        $serverConfiguration = ServerConfigurationService::getInstance()->findByAuthID($auth_id);
                                        if ($serverConfiguration != null) {
                                            $this->requestHeaders[Constants::ServerID] = $serverConfiguration->id;
                                            $this->scopes = $serverConfiguration->scopes;
                                        }
                                        break;
                                }
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
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

<?php

namespace Src\Controller\PushNotification;


use Src\Controller\Configuration\ConfigurationQuery;
use Src\Controller\Configuration\Request\CriterSpecification;
use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Definition\DateTime;
use Src\Definition\DaysOfWeek;
use Src\Definition\TimeComponent;
use Src\Entity\User\User;
use Src\Service\Configuration\ConfigurationService;
use Src\Service\Log\LogService;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Service\VoIPush\PushNotifications;
use Src\Utils\DateTimeUtils;
use Src\Utils\StringUtils;

class PushController extends PreprocessingController
{
    public function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->boardPush();
            case Configuration::USER:
                return $this->userPush();
            case Configuration::USER_DEVICE:
                return $this->userDevicePush();
            case Configuration::SERVER:
                return $this->serverPush();
        }
        return self::notFoundResponse();
    }

    function mapStringToArray($config)
    {
        return (array)json_decode($config->strings, TRUE);
    }

    function isExcluded($config)
    {
        return ($config["excludes"] != null && $config["forAlarm"]);
    }

    function isIncluded($config)
    {
        return ($config["includes"] != null && $config["forAlarm"]);
    }

    function getTimeComponent($timeComp, $dtComponent)
    {
        switch ($dtComponent) {
            case TimeComponent::second:
                return $timeComp["seconds"];
            case TimeComponent::minute:
                return $timeComp["minutes"];
            case TimeComponent::hour:
                return $timeComp["hours"];
            case TimeComponent::day:
                return $timeComp["mday"];
            case TimeComponent::daysOfWeek:
                $wday = $timeComp["wday"];
                switch ($wday) {
                    case 0:
                        return DaysOfWeek::Sunday;
                    case 1:
                        return DaysOfWeek::Monsday;
                    case 2:
                        return DaysOfWeek::Tuesday;
                    case 3:
                        return DaysOfWeek::Wednesday;
                    case 4:
                        return DaysOfWeek::Thursday;
                    case 5:
                        return DaysOfWeek::Friday;
                    case 6:
                        return DaysOfWeek::Saturday;
                }
                break;
            case TimeComponent::month:
                return $timeComp["mon"];
            case TimeComponent::year:
                return $timeComp["year"];
        }
        return null;
    }

    function isTimeInRange($timeComp, $configuration, $default = true)
    {
        $dtComponents = DateTime::component;
        for ($i = 0; $i < sizeof($dtComponents); $i++) {
            $dtComponent = $dtComponents[$i];
            $isTimeComponentInRange = $this->isTimeComponentSelectedInConfiguration($timeComp, $configuration, $dtComponent);
            if (!$isTimeComponentInRange) {
                return false;
            } else {
                if ($i == sizeof($dtComponents) - 1) {
                    return true;
                }
            }
        }
        return $default;
    }

    function getTimeConfiguration($configuration, $dtComponent)
    {
        return $configuration[$dtComponent];
    }

    function isTimeComponentSelectedInConfiguration($timeComp, $configuration, $dtComponent)
    {
        $timeConfig = $this->getTimeConfiguration($configuration, $dtComponent);
        $timeComponent = $this->getTimeComponent($timeComp, $dtComponent);
        $selectedItems = $timeConfig["selectedItems"];
//        var_dump($timeConfig);
//        var_dump($timeComponent);
//        var_dump($selectedItems);
        for ($i = 0; $i < sizeof($selectedItems); $i++) {
            $selectedItem = $selectedItems[$i];
            if ($selectedItem && $timeComponent == $selectedItem["value"]) {
                if (!$selectedItem["isSelected"]) {
                    return false;
                } else if ($selectedItem["isSelected"]) {
                    return true;
                }
            }
        }

        return true;
    }

    function searchTimeSettingConfigurations(User $user)
    {
        try {
            $configurationQuery = new ConfigurationQuery(array("is_deleted" => false, "is_activated" => true,
                "isAnd" => true));
            $configurationQuery->id_spec = new CriterSpecification(array("list" => $user->preferences,
                "isAnd" => false));
            $configurationQuery->type_spec = new CriterSpecification(array("list" => "3", "isAnd" => false));
            $configurationQuery->category_spec = new CriterSpecification(array("list" => "2", "isAnd" => false));

            $configsStr = ConfigurationService::getInstance()->searchDB($configurationQuery);
            return $configsStr;
        } catch (\Exception $e) {
            return null;
        }
    }

    function pushDevice(User $user)
    {
        $userDevicesID = StringUtils::trimStringToArray("|", $user->user_device_id);
//        var_dump($userDevicesID);

        $content = json_encode($this->requestBody);
        $configuration = $this->configuration;
        $type = 1;
        $level = 3;
        $scopes = "1,0,0,0|0,1,0,0|0,0,1,0|0,0,0,1";

        LogService::getInstance()->insert(array("content" => $content,
            "configuration" => $configuration,
            "type" => $type,
            "level" => $level,
            "scopes" => $scopes));


        // Message payload
        $msg_payload = array(
            'mtitle' => 'Test push notification title',
            'mdesc' => 'Test push notification description',
            'msgcnt' => "msgcnt",
            'msubtitle' => "Test push notification SubTitle",
            'tickerText' => "Test push notification Ticker Text",
            'title' => "Test push notification title",
            'userInteraction' => true,
            'vibrate' => "0"
        );
        foreach ($userDevicesID as $userDeviceID) {
            $userDevice = UserDeviceService::getInstance()->findFirst($userDeviceID);
            var_dump($userDevice->push_registration_token);

            // For Android
            $regId = "dVRMTwRWz78:APA91bEfxoZbku9iF3QgaO6mdo1kk_F-H290150h4ovbko4cdca_-aRNJe9D5LVRypjIlFcdGN6G5CvayA4BPOiIGJYAA2AAF217dFKoQEBPd7mQRL4ZDZNRy_0pmppdcoL_7Cb_hi1e";
            // For iOS
            $deviceToken = 'FE66489F304DC75B8D6E8200DFF8A456E8DAEACEC428B427E9518741C92C6660';
            // For WP8
            $uri = 'http://s.notify.live.net/u/1/sin/HmQAAAD1XJMXfQ8SR0b580NcxIoD6G7hIYP9oHvjjpMC2etA7U_xy_xtSAh8tWx7Dul2AZlHqoYzsSQ8jQRQ-pQLAtKW/d2luZG93c3Bob25lZGVmYXVsdA/EKTs2gmt5BG_GB8lKdN_Rg/WuhpYBv02fAmB7tjUfF7DG9aUL4';

            //// Push
//            PushNotifications::android($msg_payload, $regId);
            PushNotifications::android($msg_payload, $userDevice->push_registration_token);
            //TODO
            // iOS CallKit
        }
    }

    private function boardPush()
    {
        $userIds = StringUtils::trimStringToArray("|", $this->interceptData->user_id);
        if ($userIds) {
            foreach ($userIds as $userId) {
                $user = UserService::getInstance()->findFirst($userId);
                $configsStr = $this->searchTimeSettingConfigurations($user);
                $configurations = array_map(array($this, "mapStringToArray"), $configsStr);
                $excludes = array_filter($configurations, array($this, "isExcluded"));
                $includes = array_filter($configurations, array($this, "isIncluded"));

//        var_dump($excludes);
//        var_dump($includes);

                $isExcluded = false;
                foreach ($excludes as $exclude) {
                    $timezone = $exclude["excludes"]["timezone"]; // '+0700' e.g
                    $tz = new \DateTimeZone("+0000");
                    if ($timezone) {
                        $tz = new \DateTimeZone($timezone);
                    }
                    $currentTime = DateTimeUtils::getCurrentTime(DateTime::StandardFormat, $tz);
                    $timeComp = getdate($currentTime->getTimestamp() + $currentTime->getOffset());
                    if ($this->isTimeInRange($timeComp, $exclude["excludes"]) == true) {
//                var_dump("Excluded Alarm");
                        $isExcluded = true;
                        break;
                    }
                }

                if (!$isExcluded) {
                    foreach ($includes as $include) {
                        $timezone = $include["includes"]["timezone"]; // '+0700' e.g
                        $tz = new \DateTimeZone("+0000");
                        if ($timezone) {
                            $tz = new \DateTimeZone($timezone);
                        }
                        $currentTime = DateTimeUtils::getCurrentTime(DateTime::StandardFormat, $tz);
                        $timeComp = getdate($currentTime->getTimestamp() + $currentTime->getOffset());
                        if ($this->isTimeInRange($timeComp, $include["includes"])) {
//                var_dump("Push Alarm");
                            $this->pushDevice($user);
                            break;
                        }
                    }
                }
            }
        }

        return self::jsonEncodedResponse(null);
    }

    private function userPush()
    {
        return self::notFoundResponse();
    }

    private function userDevicePush()
    {
        return self::notFoundResponse();
    }

    private function serverPush()
    {
        return self::notFoundResponse();
    }


    public static function searchConfiguration($configurationQuery)
    {
        try {
            $configurations = ConfigurationService::getInstance()->searchDB($configurationQuery);;
            return $configurations;
        } catch (\Exception $e) {
            return null;
        }
    }

}

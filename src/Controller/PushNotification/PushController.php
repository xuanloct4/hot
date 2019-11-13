<?php

namespace Src\Controller\PushNotification;


use Src\Controller\PreprocessingController;
use Src\Definition\Configuration;
use Src\Service\Log\LogService;
use Src\Service\User\UserDeviceService;
use Src\Service\VoIPush\PushNotifications;
use Src\Utils\StringUtils;

class PushController extends PreprocessingController
{
    public function processPOSTRequest() {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->tickleBoard();
            case Configuration::USER:
                return $this->tickleUser();
            case Configuration::USER_DEVICE:
                return $this->tickleUserDevice();
            case Configuration::SERVER:
                return $this->tickleServer();
        }
        return self::notFoundResponse();
    }

    private function tickleBoard()
    {
        return self::notFoundResponse();
    }


    private function tickleUser()
    {
        return self::notFoundResponse();
    }

    private function tickleUserDevice()
    {
        $userDevicesID = StringUtils::trimStringToArray("|", $this->interceptData->user_device_id);



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

        return self::jsonEncodedResponse(null);
    }

    private function tickleServer()
    {
        return self::notFoundResponse();
    }

}

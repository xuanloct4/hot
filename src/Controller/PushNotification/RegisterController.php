<?php

namespace Src\Controller\PushNotification;


use Src\Controller\Controller;
use Src\Controller\PreprocessingController;
use Src\Controller\PushNotification\Request\UserDeviceRegisterRequest;
use Src\Controller\PushNotification\Response\RegisterResponse;
use Src\Definition\Configuration;
use Src\Service\User\UserDeviceService;
use Src\Service\User\UserService;
use Src\Utils\StringUtils;

class RegisterController extends PreprocessingController
{
    function processPOSTRequest()
    {
        switch ($this->configuration) {
            case Configuration::BOARD:
                return $this->registerBoard();
            case Configuration::USER:
                return $this->registerUser();
            case Configuration::USER_DEVICE:
                $userDeviceRegisterRequest = new UserDeviceRegisterRequest($this->requestBody);
                return $this->registerUserDevice($userDeviceRegisterRequest);
            case Configuration::SERVER:
                return $this->registerServer();
        }
        return self::notFoundResponse();
    }

    private function registerBoard() {
        //TODO
        return self::notFoundResponse();
    }

    private function registerUser() {
        //TODO
        return self::notFoundResponse();
    }

    private function registerUserDevice(UserDeviceRegisterRequest $userDeviceRegisterRequest) {

        switch ($this->chanelId) {
            case Configuration::BOARD:
               break;
            case Configuration::USER:
                try {
                    $response = null;
                    $userConfiguration = $this->interceptData;
                    $userDeviceIds = StringUtils::trimStringToArrayWithNonEmptyElement("|", $userConfiguration->user_device_id);
                    $userDevice = null;
                    if ($userDeviceRegisterRequest->id && $this->isInArray($userDeviceIds, $userDeviceRegisterRequest->id)) {
                        $userDevice = UserDeviceService::getInstance()->findFirstByAND($userDeviceRegisterRequest->id);
                    } else if ($userDeviceRegisterRequest->model && $userDeviceRegisterRequest->os) {
                        $userDevice = UserDeviceService::getInstance()->findByModelAndOS($userDeviceRegisterRequest->model, $userDeviceRegisterRequest->os);
                    }

                    \Src\System\Configuration::getInstance()->getConnection()->beginTransaction();
                    if ($userDevice != null) {
                        $userDeviceRegisterRequest->id = $userDevice->id;
                        $userDeviceRegisterRequest->board_id = $userDevice->board_id;
                        $userDeviceRegisterRequest->user_id = $userDevice->user_id;
                        $userDeviceRegisterArray = $userDeviceRegisterRequest->toArray();
//                        var_dump($userDeviceRegisterArray);
                        UserDeviceService::getInstance()->update($userDeviceRegisterArray);
                    } else {
                        $userDeviceRegisterRequest->user_id = $userConfiguration->id;
                        $userDeviceRegisterRequest->board_id = $userConfiguration->board_id;
                        $userDeviceRegisterArray = $userDeviceRegisterRequest->toArray();
                        unset($userDeviceRegisterArray["id"]);
                        $insertedUserDeviceId = UserDeviceService::getInstance()->insert($userDeviceRegisterArray);
                        if (!$this->isInArray($userDeviceIds, $insertedUserDeviceId)) {
                            array_push($userDeviceIds, $insertedUserDeviceId);
                            UserService::getInstance()->update(array("id" => $userConfiguration->id,
                                "user_device_id" => StringUtils::joinArrayToString("|", $userDeviceIds)));
                        }
                        $response = new RegisterResponse($insertedUserDeviceId);
                    }
                    \Src\System\Configuration::getInstance()->getConnection()->commit();
                    return Controller::jsonEncodedResponse($response);
                } catch (\Exception $e) {
                    \Src\System\Configuration::getInstance()->getConnection()->rollback();
                    return self::respondUnprocessableEntity();
                }
            case Configuration::USER_DEVICE:
                break;
            case Configuration::SERVER:
                break;
        }
        return self::notFoundResponse();
    }

   private function registerServer() {
        //TODO
       return self::notFoundResponse();
   }

   function isInArray(Array $ids, $id) {
        foreach ($ids as $item) {
            if ($item == $id) {
                return true;
            }
        }

        return false;
   }
}

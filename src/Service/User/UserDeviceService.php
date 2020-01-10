<?php

namespace Src\Service\User;

use Src\Entity\User\UserDevice;
use Src\Service\DBService;
use Src\System\Configuration;

class UserDeviceService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserDeviceService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new UserDevice();
    }

    // CRUD
    public function findByAuthID($auth_id)
    {
        return $this->findFirstByAND(array('authorized_id' => $auth_id));
    }

    // CRUD
    public function findByModelAndOS($model,$os)
    {
        $result = $this->findFirstByAND(array(
            'model' => $model,
            'os' => $os));
        return $result;
    }
}

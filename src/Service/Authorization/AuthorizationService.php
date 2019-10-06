<?php

namespace Src\Service\Authorization;

use Src\Entity\Authorization\Authorization;
use Src\Service\DBService;

class AuthorizationService extends DBService
{

    // Hold the class instance.
    private static $instance = null;

    public function table() {
        return Authorization::table();
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new AuthorizationService();
        }

        return self::$instance;
    }

    public function fetchClass(){
        return 'Src\Entity\Authorization\Authorization';
    }

    // CRUD
    public function findFirstByIDAndCode($uuid, $code)
    {
        $result = $this->findFirstByAND(array("uuid" => $uuid, "authorized_code" => $code));
        return $result;
    }
}

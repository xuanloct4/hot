<?php

namespace Src\Service\Authorization;

use Src\Definition\Configuration;
use Src\Entity\Authorization\Authorization;
use Src\Service\DBService;
use Src\Utils\Encryption\RSA;
use Src\Utils\StringUtils;

class AuthorizationService extends DBService
{
    // Hold the class instance.
    private static $instance = null;
    public function sampleEntity() {
        return new Authorization();
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new AuthorizationService();
        }

        return self::$instance;
    }

    // CRUD
    public function findFirstByIDAndCode($uuid, $code, $configuration)
    {
        $realUUID = "$configuration"."_"."$uuid";
//        $result = $this->findFirstByAND(array("uuid" => $realUUID, "authorized_code" => $code));
        $list = $this->findByAND(array("uuid" => $realUUID));
        $decodedAuthorizedCode = RSA::decrypt($code);
        foreach ($list as $item) {
            $decodedItemAuthorizedCode = RSA::decrypt($item->authorized_code);
            if (StringUtils::compareString($decodedAuthorizedCode,$decodedItemAuthorizedCode)) {
                return $item;
            }
        }
        return null;
    }

    public function updateTokens() {

    }
}

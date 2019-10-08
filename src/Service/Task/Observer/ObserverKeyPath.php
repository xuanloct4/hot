<?php

namespace Src\Service\Task\Observer;

use Src\Utils\StringUtils;

class ObserverKeyPath
{
    private static $instance = null;
    private function __construct()
    {
        $this->keyUUIDs = array();
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ObserverKeyPath();
        }
        return self::$instance;
    }

    private $keyUUIDs;

    public function addKey($uuidKey) {
        array_push($this->keyUUIDs,$uuidKey);
    }

    public function addRandomUUIDKey($prefix="", $sufix="") {
        $uuidKey = $this->randomUUID($prefix,$sufix);
        array_push($this->keyUUIDs,$uuidKey);
    }

    public function isKeyExists($key) {
        foreach ($this->keyUUIDs as $myKey) {
            if (strcmp($myKey,$key) == 0) {
                return true;
            }
        }
        return false;
    }

    public function randomUUID($prefix="", $sufix="") {
        $isExists = true;
        while ($isExists) {
            $uuid = $prefix;
            $uuid .= StringUtils::generateRandomString();
            $uuid .= $sufix;
            $isExists = $this->isKeyExists($uuid);
        }

        return $uuid;
    }
}
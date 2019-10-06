<?php

namespace Src\Service\Board;

use Src\Service\DBService;
use Src\Entity\Board\BoardConfiguration;

class BoardConfigurationService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public function table() {
        return BoardConfiguration::table();
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new BoardConfigurationService();
        }

        return self::$instance;
    }

    public function fetchClass(){
        return 'Src\Entity\Board\BoardConfiguration';
    }

    // CRUD
    public function findByAuthID($auth_id)
    {
        $result = $this->findFirstByAND(array("authorized_id" => $auth_id));
        return $result;
    }
}

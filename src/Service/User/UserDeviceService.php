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
        $statement = "
            SELECT 
            *
            FROM
            $this->table
            WHERE authorized_id = :authorized_id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('authorized_id' => $auth_id));
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\User\UserDevice');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}

<?php

namespace Src\Service\Server;

use Src\Entity\Server\ServerConfiguration;
use Src\Service\DBService;
use Src\System\Configuration;

class ServerConfigurationService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ServerConfigurationService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new ServerConfiguration();
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Server\ServerConfiguration');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}

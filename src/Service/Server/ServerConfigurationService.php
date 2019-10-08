<?php

namespace Src\Service\Server;

use Src\Entity\Server\ServerConfiguration;
use Src\System\Configuration;

class ServerConfigurationService
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

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (name, description, status, authorized_id, configuration, scopes, is_deleted, is_activated)
//            VALUES
//            (:name, :description, :status, :authorized_id, :configuration, :scopes, :is_deleted, :is_activated);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'name' => $input['name'],
//                'description' => $input['description'],
//                'status' => $input['status'],
//                'authorized_id' => $input['authorized_id'],
//                'configuration' => $input['configuration'],
//                'scopes' => $input['scopes'],
//                'is_deleted' => $input['is_deleted'],
//                'is_activated' => $input['is_activated']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
//
//    public function update($id, Array $input)
//    {
//        $statement = "
//            UPDATE $this->table
//            SET
//            name = :name,
//            description  = :description,
//            status = :status,
//            authorized_id = :authorized_id,
//            configuration  = :configuration,
//            scopes = :scopes,
//            is_deleted = :is_deleted,
//            is_activated = :is_activated
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int)$id,
//                'name' => $input['name'],
//                'description' => $input['description'],
//                'status' => $input['status'],
//                'authorized_id' => $input['authorized_id'],
//                'configuration' => $input['configuration'],
//                'scopes' => $input['scopes'],
//                'is_deleted' => $input['is_deleted'],
//                'is_activated' => $input['is_activated']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}
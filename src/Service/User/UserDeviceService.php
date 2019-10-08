<?php

namespace Src\Service\User;

use Src\Entity\User\UserDevice;
use Src\System\Configuration;

class UserDeviceService
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

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (name, description, model, manufacturer, version, os, firmware, user_id, status, authorized_id, configuration, scopes, is_activated, is_deleted)
//            VALUES
//            (:name, :description, :model, :manufacturer, :version, :os, :firmware, :user_id, :status, :authorized_id, :configuration, :scopes, :is_activated, :is_deleted);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'name' => $input['name'],
//                'description' => $input['description'],
//                'model' => $input['model'],
//                'manufacturer' => $input['manufacturer'],
//                'version' => $input['version'],
//                'os' => $input['os'],
//                'firmware' => $input['firmware'],
//                'user_id' => $input['user_id'],
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
//            model = :model,
//            manufacturer = :manufacturer,
//            version  = :version,
//            os = :os,
//            firmware = :firmware,
//            user_id  = :user_id,
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
//                'model' => $input['model'],
//                'manufacturer' => $input['manufacturer'],
//                'version' => $input['version'],
//                'os' => $input['os'],
//                'firmware' => $input['firmware'],
//                'user_id' => $input['user_id'],
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
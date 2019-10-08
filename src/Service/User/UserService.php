<?php

namespace Src\Service\User;

use Src\Entity\User\User;
use Src\Service\DBService;
use Src\System\Configuration;

class UserService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new User();
    }

    // CRUD
    public function findByAuthID($auth_id)
    {
        return $this->findFirstByAND(array('authorized_id' => $auth_id));
    }

//        public function insert(Array $input)
//        {
//            $statement = "
//            INSERT INTO $this->table
//            (name, address, location, phone, gender, status, authorized_id, preferences, scopes, is_activated, is_deleted)
//            VALUES
//            (:name, :address, :location, :phone, :gender, :status, :authorized_id, :preferences, :scopes, :is_activated, :is_deleted);
//            ";
//
//            try {
//                $statement = $this->db->prepare($statement);
//                $statement->execute(array(
//                    'name' => $input['name'],
//                    'address' => $input['address'],
//                    'location' => $input['location'],
//                    'phone' => $input['phone'],
//                    'gender' => $input['gender'],
//                    'status' => $input['status'],
//                    'authorized_id' => $input['authorized_id'],
//                    'preferences' => $input['user_id'],
//                    'scopes' => $input['status'],
//                    'is_deleted' => $input['is_deleted'],
//                    'is_activated' => $input['is_activated']
//                ));
//                return $statement->rowCount();
//            } catch (\PDOException $e) {
//                exit($e->getMessage());
//            }
//        }
//
//        /**
//         * @param $id
//         * @param array $input
//         * @return int
//         */
//        public function update($id, Array $input)
//        {
//            $statement = "
//            UPDATE $this->table
//            SET
//            name = :name,
//            address  = :address,
//            location = :location,
//            phone = :phone,
//            gender  = :gender,
//            status = :status,
//            authorized_id = :authorized_id,
//            preferences  = :preferences,
//            scopes = :scopes,
//            is_deleted = :is_deleted,
//            is_activated = :is_activated
//            WHERE id = :id;
//            ";
//
//            try {
//                $statement = $this->db->prepare($statement);
//                $statement->execute(array(
//                    'id' => (int)$id,
//                    'name' => $input['name'],
//                    'address' => $input['address'],
//                    'location' => $input['location'],
//                    'phone' => $input['phone'],
//                    'gender' => $input['gender'],
//                    'status' => $input['status'],
//                    'authorized_id' => $input['authorized_id'],
//                    'preferences' => $input['user_id'],
//                    'scopes' => $input['status'],
//                    'is_deleted' => $input['is_deleted'],
//                    'is_activated' => $input['is_activated']
//                ));
//                return $statement->rowCount();
//            } catch (\PDOException $e) {
//                exit($e->getMessage());
//            }
//        }
}
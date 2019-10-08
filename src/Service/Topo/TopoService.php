<?php

namespace Src\Service\Topo;

use Src\Entity\Topo\Topo;

class TopoService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new TopoService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new Topo();
    }

    // CRUD

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (board_internal_contact, sensor_internal_contact, description)
//            VALUES
//            (:board_internal_contact, :sensor_internal_contact, :description);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'board_internal_contact' => $input['board_internal_contact'],
//                'sensor_internal_contact' => $input['sensor_internal_contact'],
//                'description' => $input['description']
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
//            board_internal_contact = :board_internal_contact,
//            sensor_internal_contact  = :sensor_internal_contact,
//            description = :description
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int)$id,
//                'board_internal_contact' => $input['board_internal_contact'],
//                'sensor_internal_contact' => $input['sensor_internal_contact'],
//                'description' => $input['description']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}
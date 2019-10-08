<?php

namespace Src\Service\Scope;

use Src\Entity\Scope\ScopeDefinition;
use Src\System\Configuration;

class ScopeDefinitionService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ScopeDefinitionService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new ScopeDefinition();
    }


    // CRUD

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (level, order, actions, description)
//            VALUES
//            (:level, :order, :actions, :description);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'level' => $input['level'],
//                'order' => $input['order'],
//                'actions' => $input['actions'],
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
//            level = :level,
//            order  = :order,
//            actions = :actions,
//            description = :description
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int) $id,
//                'level' => $input['level'],
//                'order' => $input['order'],
//                'actions' => $input['actions'],
//                'description' => $input['description']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}

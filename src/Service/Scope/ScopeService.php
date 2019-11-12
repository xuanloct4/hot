<?php

namespace Src\Service\Scope;

use Src\Entity\Scope\Scope;
use Src\Service\DBService;
use Src\System\Configuration;


class ScopeService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ScopeService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new Scope();
    }

    // CRUD

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (scope_pair, description)
//            VALUES
//            (:scope_pair, :description);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'scope_pair' => $input['scope_pair'],
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
//            scope_pair = :scope_pair,
//            description  = :description
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int) $id,
//                'scope_pair' => $input['scope_pair'],
//                'description' => $input['description']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}

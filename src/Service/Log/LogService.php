<?php

namespace Src\Service\Log;

use Src\Entity\Log\Log;
use Src\System\Configuration;

class LogService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new LogService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new Log();
    }

    // CRUD

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (content, configuration, type, level, scopes)
//            VALUES
//            (:content, :configuration, :type, :level, :scopes);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'content' => $input['content'],
//                'configuration' => $input['configuration'],
//                'type' => $input['type'],
//                'level' => $input['level'],
//                'scopes' => $input['scopes']
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
//            content = :content,
//            configuration  = :configuration,
//            type = :type,
//            level = :level,
//            scopes  = :scopes
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int) $id,
//                'content' => $input['content'],
//                'configuration' => $input['configuration'],
//                'type' => $input['type'],
//                'level' => $input['level'],
//                'scopes' => $input['scopes']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}

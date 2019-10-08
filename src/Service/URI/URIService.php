<?php

namespace Src\Service\URI;


use Src\Entity\URI\URI;
use Src\Service\DBService;
use Src\System\Configuration;

class URIService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new URIService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new URI();
    }

    // CRUD
    public function findByType($type)
    {
        return $this->findByAND(array('type' => $type));
    }

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (representation, content, virtual_address, physical_address, authorized_id, scopes, type)
//            VALUES
//            (:representation, :content, :virtual_address, :physical_address, :authorized_id, :scopes, :type);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'representation' => $input['representation'],
//                'content' => $input['content'],
//                'virtual_address' => $input['virtual_address'],
//                'physical_address' => $input['physical_address'],
//                'authorized_id' => $input['authorized_id'],
//                'scopes' => $input['scopes'],
//                'type' => $input['type']
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
//            representation = :representation,
//            content  = :content,
//            virtual_address = :virtual_address,
//            physical_address = :physical_address,
//            authorized_id  = :authorized_id,
//            scopes = :scopes,
//            type = :type
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int)$id,
//                'representation' => $input['representation'],
//                'content' => $input['content'],
//                'virtual_address' => $input['virtual_address'],
//                'physical_address' => $input['physical_address'],
//                'authorized_id' => $input['authorized_id'],
//                'scopes' => $input['scopes'],
//                'type' => $input['type']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}
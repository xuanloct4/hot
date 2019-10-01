<?php

namespace Src\Service\URI;


use Src\Entity\URI\URI;
use Src\System\Configuration;

class URIService {

    private $db = null;
    private $table;

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        $this->db = Configuration::getInstance()->getConnection();
        $this->table = URI::$table_name;
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new URIService();
        }

        return self::$instance;
    }

    // CRUD
    public function findAll()
    {
        $statement = "
            SELECT 
            *
            FROM
            $this->table;
            ";

        try {
            $statement = $this->db->query($statement);
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\URI\URI');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
            SELECT 
            *
            FROM
            $this->table
            WHERE id = ?;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\URI\URI');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByType($type)
    {
        $statement = "
            SELECT 
            *
            FROM
            $this->table
            WHERE type = :type;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('type' => $type));
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\URI\URI');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO $this->table 
            (representation, content, virtual_address, physical_address, authorized_id, scopes, type)
            VALUES
            (:representation, :content, :virtual_address, :physical_address, :authorized_id, :scopes, :type);
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'representation' => $input['representation'],
                'content' => $input['content'],
                'virtual_address' => $input['virtual_address'],
                'physical_address' => $input['physical_address'],
                'authorized_id' => $input['authorized_id'],
                'scopes' => $input['scopes'],
                'type' => $input['type']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE $this->table
            SET 
            representation = :representation,
            content  = :content,
            virtual_address = :virtual_address,
            physical_address = :physical_address,
            authorized_id  = :authorized_id,
            scopes = :scopes,
            type = :type
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int)$id,
                'representation' => $input['representation'],
                'content' => $input['content'],
                'virtual_address' => $input['virtual_address'],
                'physical_address' => $input['physical_address'],
                'authorized_id' => $input['authorized_id'],
                'scopes' => $input['scopes'],
                'type' => $input['type']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM $this->table
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
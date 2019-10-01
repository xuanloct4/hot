<?php

namespace Src\Service\Log;

use Src\Entity\Log\Log;
use Src\System\Configuration;

class LogService
{

    private $db = null;
    private $table;

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        $this->db = Configuration::getInstance()->getConnection();
        $this->table = Log::$table_name;
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new LogService();
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Log\Log');
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Log\Log');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO $this->table 
            (content, configuration, type, level, scopes)
            VALUES
            (:content, :configuration, :type, :level, :scopes);
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'content' => $input['content'],
                'configuration' => $input['configuration'],
                'type' => $input['type'],
                'level' => $input['level'],
                'scopes' => $input['scopes']
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
            content = :content,
            configuration  = :configuration,
            type = :type,
            level = :level,
            scopes  = :scopes
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'content' => $input['content'],
                'configuration' => $input['configuration'],
                'type' => $input['type'],
                'level' => $input['level'],
                'scopes' => $input['scopes']
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

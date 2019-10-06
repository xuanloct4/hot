<?php

namespace Src\Service;


use Src\Entity\Authorization\Authorization;
use Src\System\Configuration;

abstract class DBService
{
    public abstract function table();
    public abstract static function getInstance();
    public abstract function fetchClass();

    protected function dbConnection() {
        return Configuration::getInstance()->getConnection();
    }

    // The constructor is private
    // to prevent initiation with outer code.
    protected function __construct()
    {
    }

    // CRUD
    public function findAll()
    {
        $table = $this->table();
        $statement = "
            SELECT 
            *
            FROM
            $table;
            ";

        try {
            $statement = $this->db->query($statement);
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, $this->fetchClass());
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $table = $this->table();
        $statement = "
            SELECT 
            *
            FROM
            $table
            WHERE id = ?;
            ";

        try {
            $statement = $this->dbConnection()->prepare($statement);
            $statement->execute(array($id));
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, $this->fetchClass());
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findOne($id)
    {
        return $this->findFirst($id);
    }


    public function findFirst($id)
    {
        $result = $this->find($id);
        if (sizeof($result) > 0) {
            return $result[0];
        }
        return null;
    }


    public function findLast($id)
    {
        $result = $this->find($id);
        $size = sizeof($result);
        if ($size > 0) {
            return $result[$size - 1];
        }
        return null;
    }

    public function findBy(Array $input, $isAnd)
    {
        $table = $this->table();

        $where= "";
        $keys = array_keys($input);
        for ($i = 0; $i < sizeof($keys); $i++) {
            if ($i > 0) {
                if($isAnd == true) {
                    $where = $where . "\n" . "AND" . " ";
                } else {
                    $where = $where . "\n" . "OR" . " ";
                }
            }
            $where = $where.$keys[$i]." = :".$keys[$i];

        }

        $statement = "
            SELECT
            *
            FROM
            $table
            WHERE $where;
            ";
//        var_dump($statement);
        try {
            $statement = $this->dbConnection()->prepare($statement);
            $statement->execute($input);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, $this->fetchClass());
//            var_dump($result);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByAND(Array $input)
    {
        return $this->findBy($input, true);
    }

    public function findFirstByAND(Array $input)
    {
        $result = $this->findBy($input, true);
        if (sizeof($result) > 0) {
            return $result[0];
        }
        return null;
    }

    public function findLastByAND(Array $input)
    {
        $result = $this->findBy($input, true);
        $size = sizeof($result);
        if ($size > 0) {
            return $result[$size - 1];
        }
        return null;
    }

    public function findByOR(Array $input)
    {
        return $this->findBy($input, false);
    }

    public function findFirstByOR(Array $input)
    {
        $result = $this->findByOR($input, false);
        if (sizeof($result) > 0) {
            return $result[0];
        }
        return null;
    }

    public function findLastByOR(Array $input)
    {
        $result = $this->findByOR($input, false);
        $size = sizeof($result);
        if ($size > 0) {
            return $result[$size - 1];
        }
        return null;
    }

    public function findByANDSort(Array $input, Array $sortBy)
    {

    }


    public function findByORSort(Array $input, Array $sortBy)
    {

    }

    public function insert(Array $input)
    {
        $table = $this->table();

        $fields= "(";
        $values= "(";
        $keys = array_keys($input);
        for ($i = 0; $i < sizeof($keys); $i++) {
            if ($i > 0) {
                $fields = $fields.", ";
                $values = $values.", ";
            }
            $fields = $fields.$keys[$i];
            $values = $values.":".$keys[$i];
        }

        $fields = $fields.")";
        $values = $values.")";

        $statement = "
            INSERT INTO $table
            $fields
            VALUES
            $values;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute($input);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update(Array $input)
    {
        if (array_key_exists("id", $input)) {
//            $id = (int)$input["id"];
            $inputId = $input;
            unset($inputId["id"]);
        } else {
            exit("Entity Id not found");
        }

        $table = $this->table();
        $keyValues= "";
        $keys = array_keys($inputId);
        for ($i = 0; $i < sizeof($keys); $i++) {
            $keyValues= $keyValues.$keys[$i]." = :".$keys[$i];
            if ($i < sizeof($keys)-1) {
                $keyValues= $keyValues.",\n";
            }
        }

        $statement = "
            UPDATE $table
            SET
            $keyValues
            WHERE id = :id;
            ";
//        var_dump($statement);
        try {
            $statement = $this->dbConnection()->prepare($statement);
            $statement->execute($input);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $table = $this->table();
        $statement = "
            DELETE FROM $table
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
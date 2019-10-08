<?php

namespace Src\Service;

use Src\System\Configuration;

interface iDBService {
    public function sampleEntity();
    public  static function getInstance();
}

abstract class DBService implements iDBService
{

    public function fetchClass(){
        return get_class($this->sampleEntity());
    }

    protected function dbConnection() {
        return Configuration::getInstance()->getConnection();
    }

    public function table() {
        $class = $this->fetchClass();
        return (new $class())::table();
    }

    // The constructor is private
    // to prevent initiation with outer code.
    protected function __construct()
    {
    }

    // CRUD
	public function executeDB($statement, $input)
	{
        try {
            $statement = $this->dbConnection()->prepare($statement);
            $statement->execute($input);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }	
	}
	
	public function executeAndFetchDB($statement, $input)
	{
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
	
	public function queryDB($statement)
	{
        try {
            $statement = $this->db->query($statement);
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, $this->fetchClass());
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
	}
	
    public function findAll()
    {
        $table = $this->table();
        $statement = "
            SELECT 
            *
            FROM
            $table;
            ";
			
		return $this->queryDB($statement);
    }

    public function find($id)
    {
        return $this->findBy(array("id" => (int)$id),true);
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

    public function findBy(Array $input, $isAnd)
    {
//        var_dump($input);
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
        return $this->executeAndFetchDB($statement, $input);
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

	 	$this->executeDB($statement, $input);
//	 	var_dump($this->dbConnection()->lastInsertId());
		return $this->dbConnection()->lastInsertId();
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
       return $this->executeAndFetchDB($statement, $input);
    }

    public function delete($id)
    {
        $table = $this->table();
        $statement = "
            DELETE FROM $table
            WHERE id = :id;
            ";
		
		return $this->executeDB($statement, array('id' => $id));
    }
}
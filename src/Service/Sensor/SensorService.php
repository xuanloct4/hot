<?php

namespace Src\Service\Sensor;

use Src\Entity\Sensor\Sensor;
use Src\System\Configuration;

class SensorService
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
        $this->table = Sensor::$table_name;
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SensorService();
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Sensor\Sensor');
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Sensor\Sensor');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO $this->table 
            (name, description, model, manufacturer, version, firmware, image, public_contacts, internal_contacts)
            VALUES
            (:name, :description, :model, :manufacturer, :version, :firmware, :image, :public_contacts, :internal_contacts);
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $input['name'],
                'description' => $input['description'],
                'model' => $input['model'],
                'manufacturer' => $input['manufacturer'],
                'version' => $input['version'],
                'firmware' => $input['firmware'],
                'image' => $input['image'],
                'public_contacts' => $input['public_contacts'],
                'internal_contacts' => $input['internal_contacts']
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
            name = :name,
            description  = :description,
            model = :model,
            manufacturer = :manufacturer,
            version  = :version,
            firmware = :firmware,
            image = :image,
            public_contacts = :public_contacts,
            internal_contacts  = :internal_contacts
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'name' => $input['name'],
                'description' => $input['description'],
                'model' => $input['model'],
                'manufacturer' => $input['manufacturer'],
                'version' => $input['version'],
                'firmware' => $input['firmware'],
                'image' => $input['image'],
                'public_contacts' => $input['public_contacts'],
                'internal_contacts' => $input['internal_contacts']
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
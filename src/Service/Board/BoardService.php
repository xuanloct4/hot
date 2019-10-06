<?php

namespace Src\Service\Board;

use Src\System\Configuration;
use Src\Entity\Board\Board;

class BoardService
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
        $this->table = Board::table();
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new BoardService();
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Board\Board');
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Board\Board');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO $this->table 
            (name, description, model, manufacturer, version, firmware, os, image, sensors, boards, public_contacts, internal_contacts, is_deleted, is_activated)
            VALUES
            (:name, :description, :model, :manufacturer, :version, :firmware, :os, :image, :sensors, :boards, :public_contacts, :internal_contacts, :is_deleted, :is_activated);
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
                'os' => $input['os'],
                'image' => $input['image'],
                'sensors' => $input['sensors'],
                'boards' => $input['boards'],
                'public_contacts' => $input['public_contacts'],
                'internal_contacts' => $input['internal_contacts'],
                'is_deleted' => $input['is_deleted'],
                'is_activated' => $input['is_activated']
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
            version = :version,
            firmware  = :firmware,
            os = :os,
            image = :image,
            sensors = :sensors,
            boards = :boards,
            public_contacts  = :public_contacts,
            internal_contacts = :internal_contacts,
            is_deleted = :is_deleted,
            is_activated = :is_activated
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
                'os' => $input['os'],
                'image' => $input['image'],
                'sensors' => $input['sensors'],
                'boards' => $input['boards'],
                'public_contacts' => $input['public_contacts'],
                'internal_contacts' => $input['internal_contacts'],
                'is_deleted' => $input['is_deleted'],
                'is_activated' => $input['is_activated']
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

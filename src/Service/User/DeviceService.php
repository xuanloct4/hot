<?php

namespace Src\Service\User;


use Src\Entity\User\Device;
use Src\System\Configuration;

class DeviceService
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
        $this->table = Device::$table_name;
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DeviceService();
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\User\Device');
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\User\Device');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByModelAndOS($model,$os)
    {
        $statement = "
            SELECT 
            *
            FROM
            $this->table
            WHERE model = :model
            AND os = :os;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'model' => $model,
                'os' => $os));
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\User\Device');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(DeviceDTO $dto)
    {
        $statement = "
            INSERT INTO $this->table 
            (model, manufacturer, version, firmware, os, image, configuration, scopes, is_deleted, is_activated)
            VALUES
            (:model, :manufacturer, :version, :firmware, :os, :image, :configuration, :scopes, :is_deleted, :is_activated);
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'model' => $dto->getModel(),
                'manufacturer' => $dto->getManufacturer(),
                'version' => $dto->getVersion(),
                'firmware' => $dto->getFirmware(),
                'os' => $dto->getOs(),
                'image' => $dto->getImage(),
                'configuration' => $dto->getConfiguration(),
                'scopes' => (int)$dto->getScopes(),
                'is_deleted' => $dto->getisDeleted(),
                'is_activated' => $dto->getisActivated()
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update(DeviceDTO $dto)
    {
        $statement = "
            UPDATE $this->table
            SET 
            model = :model,
            manufacturer  = :manufacturer,
            version = :version,
            firmware = :firmware,
            os = :os,
            image = :image,
            configuration  = :configuration,
            scopes = :scopes,
            is_deleted = :is_deleted,
            is_activated = :is_activated,
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int)$dto->getId(),
                'model' => $dto->getModel(),
                'manufacturer' => $dto->getManufacturer(),
                'version' => $dto->getVersion(),
                'firmware' => $dto->getFirmware(),
                'os' => $dto->getOs(),
                'image' => $dto->getImage(),
                'configuration' => $dto->getConfiguration(),
                'scopes' => (int)$dto->getScopes(),
                'is_deleted' => $dto->getisDeleted(),
                'is_activated' => $dto->getisActivated()
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

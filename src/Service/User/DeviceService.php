<?php

namespace Src\Service\User;


use Src\Entity\User\Device;
use Src\Service\DBService;
use Src\System\Configuration;

class DeviceService extends DBService
{
    // Hold the class instance.
    private static $instance = null;

    public function table() {
        return Device::table();
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DeviceService();
        }

        return self::$instance;
    }

    public function fetchClass(){
        return 'Src\Entity\User\Device';
    }

    // CRUD
    public function findByModelAndOS($model,$os)
    {
        $result = $this->findFirstByAND(array(
            'model' => $model,
            'os' => $os));
        return $result;
    }

//    public function insert(DeviceDTO $dto)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (model, manufacturer, version, firmware, os, image, configuration, scopes, is_deleted, is_activated)
//            VALUES
//            (:model, :manufacturer, :version, :firmware, :os, :image, :configuration, :scopes, :is_deleted, :is_activated);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'model' => $dto->getModel(),
//                'manufacturer' => $dto->getManufacturer(),
//                'version' => $dto->getVersion(),
//                'firmware' => $dto->getFirmware(),
//                'os' => $dto->getOs(),
//                'image' => $dto->getImage(),
//                'configuration' => $dto->getConfiguration(),
//                'scopes' => (int)$dto->getScopes(),
//                'is_deleted' => $dto->getisDeleted(),
//                'is_activated' => $dto->getisActivated()
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
//
//    public function update(DeviceDTO $dto)
//    {
//        $statement = "
//            UPDATE $this->table
//            SET
//            model = :model,
//            manufacturer  = :manufacturer,
//            version = :version,
//            firmware = :firmware,
//            os = :os,
//            image = :image,
//            configuration  = :configuration,
//            scopes = :scopes,
//            is_deleted = :is_deleted,
//            is_activated = :is_activated,
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int)$dto->getId(),
//                'model' => $dto->getModel(),
//                'manufacturer' => $dto->getManufacturer(),
//                'version' => $dto->getVersion(),
//                'firmware' => $dto->getFirmware(),
//                'os' => $dto->getOs(),
//                'image' => $dto->getImage(),
//                'configuration' => $dto->getConfiguration(),
//                'scopes' => (int)$dto->getScopes(),
//                'is_deleted' => $dto->getisDeleted(),
//                'is_activated' => $dto->getisActivated()
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}

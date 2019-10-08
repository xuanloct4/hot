<?php

namespace Src\Service\Sensor;

use Src\Entity\Sensor\Sensor;
use Src\System\Configuration;

class SensorService
{
    // Hold the class instance.
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SensorService();
        }

        return self::$instance;
    }

    public function sampleEntity()
    {
        return new Sensor();
    }


    // CRUD

//    public function insert(Array $input)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (name, description, model, manufacturer, version, firmware, image, public_contacts, internal_contacts)
//            VALUES
//            (:name, :description, :model, :manufacturer, :version, :firmware, :image, :public_contacts, :internal_contacts);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'name' => $input['name'],
//                'description' => $input['description'],
//                'model' => $input['model'],
//                'manufacturer' => $input['manufacturer'],
//                'version' => $input['version'],
//                'firmware' => $input['firmware'],
//                'image' => $input['image'],
//                'public_contacts' => $input['public_contacts'],
//                'internal_contacts' => $input['internal_contacts']
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
//            name = :name,
//            description  = :description,
//            model = :model,
//            manufacturer = :manufacturer,
//            version  = :version,
//            firmware = :firmware,
//            image = :image,
//            public_contacts = :public_contacts,
//            internal_contacts  = :internal_contacts
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int) $id,
//                'name' => $input['name'],
//                'description' => $input['description'],
//                'model' => $input['model'],
//                'manufacturer' => $input['manufacturer'],
//                'version' => $input['version'],
//                'firmware' => $input['firmware'],
//                'image' => $input['image'],
//                'public_contacts' => $input['public_contacts'],
//                'internal_contacts' => $input['internal_contacts']
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
}
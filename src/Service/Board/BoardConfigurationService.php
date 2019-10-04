<?php

namespace Src\Service\Board;

use Src\System\Configuration;
use Src\Entity\Board\BoardConfiguration;

class BoardConfigurationService
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
        $this->table = BoardConfiguration::$table_name;
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new BoardConfigurationService();
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Board\BoardConfiguration');
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Board\BoardConfiguration');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByAuthID($auth_id)
    {
        $statement = "
            SELECT 
            *
            FROM
            $this->table
            WHERE authorized_id = :authorized_id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('authorized_id' => $auth_id));
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Board\BoardConfiguration');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(BoardConfigurationDTO $boardConfigurationDTO)
    {
        $statement = "
            INSERT INTO $this->table 
            (board_id, server_configuration_id, user_device_id, user_id, topos, status, authorized_id, configuration, scopes, is_activated, is_deleted)
            VALUES
            (:board_id, :server_configuration_id, :user_device_id, :user_id, :topos, :status, :authorized_id, :configuration, :scopes, :is_activated, :is_deleted);
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'board_id' => $boardConfigurationDTO->getBoardId(),
                'server_configuration_id' => $boardConfigurationDTO->getServerConfigurationId(),
                'user_device_id' => $boardConfigurationDTO->getUserDeviceId(),
                'user_id' => $boardConfigurationDTO->getUserId(),
                'topos' => $boardConfigurationDTO->getTopos(),
                'status' => $boardConfigurationDTO->getStatus(),
                'authorized_id' => $boardConfigurationDTO->getAuthorizedId(),
                'configuration' => $boardConfigurationDTO->getConfiguration(),
                'scopes' => $boardConfigurationDTO->getScopes(),
                'is_activated' => $boardConfigurationDTO->getisActivated(),
                'is_deleted' => $boardConfigurationDTO->getisDeleted()
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update(BoardConfigurationDTO $boardConfigurationDTO)
    {
        $statement = "
            UPDATE $this->table
            SET 
            board_id = :board_id,
            server_configuration_id  = :server_configuration_id,
            user_device_id = :user_device_id,
            user_id = :user_id,
            topos = :topos,
            status = :status,
            authorized_id  = :authorized_id,
            configuration = :configuration,
            scopes = :scopes,
            is_activated = :is_activated,
            is_deleted = :is_deleted
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int)$boardConfigurationDTO->getId(),
                'board_id' => $boardConfigurationDTO->getBoardId(),
                'server_configuration_id' => $boardConfigurationDTO->getServerConfigurationId(),
                'user_device_id' => $boardConfigurationDTO->getUserDeviceId(),
                'user_id' => $boardConfigurationDTO->getUserId(),
                'topos' => $boardConfigurationDTO->getTopos(),
                'status' => $boardConfigurationDTO->getStatus(),
                'authorized_id' => $boardConfigurationDTO->getAuthorizedId(),
                'configuration' => $boardConfigurationDTO->getConfiguration(),
                'scopes' => $boardConfigurationDTO->getScopes(),
                'is_activated' => $boardConfigurationDTO->getisActivated(),
                'is_deleted' => $boardConfigurationDTO->getisDeleted()
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

<?php

namespace Src\Service\Authorization;


use Src\Entity\Authorization\Token;
use Src\System\Configuration;

class TokenService
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
        $this->table = Token::$table_name;
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new TokenService();
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Authorization\Token');
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
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Authorization\Token');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByToken($token)
    {
        $statement = "
            SELECT 
            *
            FROM
            $this->table
            WHERE token = :token;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('token' => $token));
            //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Authorization\Token');
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(TokenDTO $dto)
    {
        $statement = "
            INSERT INTO $this->table 
            (authorized_id, token, expired_interval)
            VALUES
            (:authorized_id, :token, :expired_interval);
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'authorized_id' => $dto->getAuthorizedId(),
                'token' => $dto->getToken(),
                'expired_interval' => $dto->getExpiredInterval()
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update(AuthorizationDTO $dto)
    {
        $statement = "
            UPDATE $this->table
            SET 
            authorized_id = :authorized_id,
            token = :token,
            expired_interval = :expired_interval
            WHERE id = :id;
            ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int)$dto->getId(),
                'authorized_id' => $dto->getAuthorizedId(),
                'token' => $dto->getToken(),
                'expired_interval' => $dto->getExpiredInterval()
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

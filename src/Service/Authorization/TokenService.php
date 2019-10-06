<?php

namespace Src\Service\Authorization;


use Src\Entity\Authorization\Token;
use Src\Service\DBService;
use Src\System\Configuration;

class TokenService extends DBService
{

    // Hold the class instance.
    private static $instance = null;

    public function table() {
        return Token::table();
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new TokenService();
        }

        return self::$instance;
    }

    public function fetchClass(){
        return 'Src\Entity\Authorization\Token';
    }

    // CRUD
    public function findFirstByToken($token)
    {
        $result = $this->findFirstByAND(array('token' => $token));
        return $result;
    }

//    public function insert(TokenDTO $dto)
//    {
//        $statement = "
//            INSERT INTO $this->table
//            (authorized_id, token, expired_interval)
//            VALUES
//            (:authorized_id, :token, :expired_interval);
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'authorized_id' => $dto->getAuthorizedId(),
//                'token' => $dto->getToken(),
//                'expired_interval' => $dto->getExpiredInterval()
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }
//
//    public function update(AuthorizationDTO $dto)
//    {
//        $statement = "
//            UPDATE $this->table
//            SET
//            authorized_id = :authorized_id,
//            token = :token,
//            expired_interval = :expired_interval
//            WHERE id = :id;
//            ";
//
//        try {
//            $statement = $this->db->prepare($statement);
//            $statement->execute(array(
//                'id' => (int)$dto->getId(),
//                'authorized_id' => $dto->getAuthorizedId(),
//                'token' => $dto->getToken(),
//                'expired_interval' => $dto->getExpiredInterval()
//            ));
//            return $statement->rowCount();
//        } catch (\PDOException $e) {
//            exit($e->getMessage());
//        }
//    }

}

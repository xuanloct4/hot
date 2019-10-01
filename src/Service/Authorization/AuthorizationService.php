<?php
    namespace Src\Service\Authorization;
    use Src\Entity\Authorization\Authorization;
    use Src\System\Configuration;

    class AuthorizationService {

        private $db = null;
        private $table;

        // Hold the class instance.
        private static $instance = null;

        // The constructor is private
        // to prevent initiation with outer code.
        private function __construct()
        {
            $this->db = Configuration::getInstance()->getConnection();
            $this->table = Authorization::$table_name;
        }

        // The object is created from within the class itself
        // only if the class has no instance.
        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new AuthorizationService();
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
                $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Authorization\Authorization');
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
                $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Authorization\Authorization');
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
                $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Authorization\Authorization');
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }
        
        public function insert(Array $input)
        {
            $statement = "
            INSERT INTO $this->table 
            (name, uuid, authorized_code, token, expired_interval)
            VALUES
            (:name, :uuid, :authorized_code, :token, :expired_interval);
            ";
            
            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array(
                    'name' => $input['name'],
                    'uuid'  => $input['uuid'],
                    'authorized_code' => $input['authorized_code'],
                    'token'  => $input['token'],
                    'expired_interval' => $input['expired_interval']
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
            uuid  = :uuid,
            authorized_code = :authorized_code,
            token = :token,
            expired_interval = :expired_interval
            WHERE id = :id;
            ";
            
            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array(
                    'id' => (int) $id,
                    'name' => $input['name'],
                    'uuid'  => $input['uuid'],
                    'authorized_code' => $input['authorized_code'],
                    'token'  => $input['token'],
                    'expired_interval' => $input['expired_interval']
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

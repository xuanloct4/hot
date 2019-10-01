<?php
    namespace Src\Service\User;
    
    use Src\Entity\User\User;
    use Src\System\Configuration;

    class UserService {
        
        private $db = null;
        private $table;

        // Hold the class instance.
        private static $instance = null;

        // The constructor is private
        // to prevent initiation with outer code.
        private function __construct()
        {
            $this->db = Configuration::getInstance()->getConnection();
            $this->table = User::$table_name;
        }

        // The object is created from within the class itself
        // only if the class has no instance.
        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new UserService();
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
                $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\User\User');
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
                $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\User\User');
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
                $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\User\User');
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        public function insert(Array $input)
        {
            $statement = "
            INSERT INTO $this->table 
            (name, address, location, phone, gender, status, authorized_id, preferences, scopes, is_activated, is_deleted)
            VALUES
            (:name, :address, :location, :phone, :gender, :status, :authorized_id, :preferences, :scopes, :is_activated, :is_deleted);
            ";

            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array(
                    'name' => $input['name'],
                    'address' => $input['address'],
                    'location' => $input['location'],
                    'phone' => $input['phone'],
                    'gender' => $input['gender'],
                    'status' => $input['status'],
                    'authorized_id' => $input['authorized_id'],
                    'preferences' => $input['user_id'],
                    'scopes' => $input['status'],
                    'is_deleted' => $input['is_deleted'],
                    'is_activated' => $input['is_activated']
                ));
                return $statement->rowCount();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        /**
         * @param $id
         * @param array $input
         * @return int
         */
        public function update($id, Array $input)
        {
            $statement = "
            UPDATE $this->table
            SET 
            name = :name,
            address  = :address,
            location = :location,
            phone = :phone,
            gender  = :gender,
            status = :status,
            authorized_id = :authorized_id,
            preferences  = :preferences,
            scopes = :scopes,
            is_deleted = :is_deleted,
            is_activated = :is_activated
            WHERE id = :id;
            ";

            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array(
                    'id' => (int)$id,
                    'name' => $input['name'],
                    'address' => $input['address'],
                    'location' => $input['location'],
                    'phone' => $input['phone'],
                    'gender' => $input['gender'],
                    'status' => $input['status'],
                    'authorized_id' => $input['authorized_id'],
                    'preferences' => $input['user_id'],
                    'scopes' => $input['status'],
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
<?php
    namespace Src\Service;
	use Main\Configuration;
    use Src\Entity\Person;
    
    class PersonService {
        
        private $db = null;
        
        public function __construct()
        {
			$this->db = Configuration::getInstance()->getConnection();
        }
        
        public function findAll()
        {
            $statement = "
            SELECT 
            id, firstname, lastname, firstparent_id, secondparent_id
            FROM
            person;
            ";
            
            try {
                $statement = $this->db->query($statement);
                //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Person');
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }
        
        public function find($id)
        {
            $statement = "
            SELECT 
            id, firstname, lastname, firstparent_id, secondparent_id
            FROM
            person
            WHERE id = ?;
            ";
            
            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array($id));
                //            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                $result = $statement->fetchAll(\PDO::FETCH_CLASS, 'Src\Entity\Person');
                
                //            $person = new Person();
                //            var_dump($person);
                //            $statement->setFetchMode(\PDO::FETCH_INTO, $person);
                //            $data = $statement->fetch();
                //            var_dump($data, $person);
                
                //            var_dump($result);
                //            foreach ($result as $person) {
                //                var_dump($person);
                //                var_dump(json_encode($person));
                //            }
                
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }
        
        public function insert(Array $input)
        {
            $statement = "
            INSERT INTO person 
            (firstname, lastname, firstparent_id, secondparent_id)
            VALUES
            (:firstname, :lastname, :firstparent_id, :secondparent_id);
            ";
            
            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array(
                                          'firstname' => $input['firstname'],
                                          'lastname'  => $input['lastname'],
                                          'firstparent_id' => $input['firstparent_id'] ?? null,
                                          'secondparent_id' => $input['secondparent_id'] ?? null,
                                          ));
                return $statement->rowCount();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }
        
        public function update($id, Array $input)
        {
            $statement = "
            UPDATE person
            SET 
            firstname = :firstname,
            lastname  = :lastname,
            firstparent_id = :firstparent_id,
            secondparent_id = :secondparent_id
            WHERE id = :id;
            ";
            
            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array(
                                          'id' => (int) $id,
                                          'firstname' => $input['firstname'],
                                          'lastname'  => $input['lastname'],
                                          'firstparent_id' => $input['firstparent_id'] ?? null,
                                          'secondparent_id' => $input['secondparent_id'] ?? null,
                                          ));
                return $statement->rowCount();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }
        
        public function delete($id)
        {
            $statement = "
            DELETE FROM person
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

<?php
    namespace Src\System;
    
    class DatabaseConnector {
        private static $instance = null;
        private $dbConnection = null;
        
        public function __construct()
        {
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $db   = getenv('DB_DATABASE');
            $user = getenv('DB_USERNAME');
            $pass = getenv('DB_PASSWORD');
            
            try {
                $this->dbConnection = new \PDO(
                                               "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                                               $user,
                                               $pass
                                               );
                $this->dbConnection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
                $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }
		
	    public static function getInstance()
	    {
	      if(!self::$instance)
	      {
	        self::$instance = new DatabaseConnector();
	      }
   
	      return self::$instance;
	    }
        
        public function getConnection()
        {
            return $this->dbConnection;
        }
    }

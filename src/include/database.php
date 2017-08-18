<?php

    /**
     * Singleton class
     */

    class Database {
        // Properties
        private $dbHost;
        private $dbUser;
        private $dbPass;
        private $dbName;
        
        public static $instance;

        public static function getInstance() {
            
            if(!static::$instance){
                static::$instance = new self;
            }

            return static::$instance;
        }

        public function __construct() {
            $this->dbHost = getenv('DB_HOST');
            $this->dbUser = getenv('DB_USER');
            $this->dbPass = getenv('DB_PASS');
            $this->dbName = getenv('DB_NAME');
        }

        // Connect

        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbHost;dbname=$this->dbName";
            $dbConnection = new PDO($mysql_connect_str, $this->dbUser, $this->dbPass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }
    }
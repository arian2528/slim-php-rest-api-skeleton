<?php 

    namespace Models;

    /**
     * Singleton class
     * Hint: https://www.youtube.com/watch?v=UPfdb5y2SOI&index=2&list=PLGJDCzBP5j3xGaW0AGlaVHK2TMEr2XkP9
     */

    class database {
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
        // Add '\' before PDO like '\PDO'
        // Hint: https://stackoverflow.com/questions/13426252/pdo-out-of-scope-php-composer

        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbHost;dbname=$this->dbName";
            $dbConnection = new \PDO($mysql_connect_str, $this->dbUser, $this->dbPass);
            $dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }

        

    }
<?php

    /**
    * Factory class
    */

    class factory {
        
        /**
        * New Database instance by injection
        * @param $db
        */
        protected $db;
        /**
        * The db connection established
        * @param $dbc
        */
        protected $dbc;

        public function __construct(Database $db){
            
            // Get DB Object
            $this->db = Database::getInstance();
            // Connect
            $this->dbc = $this->db->connect();

            return $this->dbc;
        }

        /**
        * Set the class to instantiate
        * @param $type
        */
        public function create($type) {
            return new service($this->dbc, $type);
        }
    }
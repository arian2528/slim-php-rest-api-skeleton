<?php

    class skills {
        
        /**
        * Variable will contain the json response
        * @param $response
        */
        private $response;
        /**
        * Main table
        * @param $table
        */
        private $table = 'skills';
        /**
        * The db connection established in factory object
        * @param $db
        */
        private $db;
        /**
        * Filters applied to the query
        * @param $filters
        */
        private $filters;
        /**
        * Standar message for no records
        * @param $noRecords
        */
        private $noRecords = 'No records match the search criteria';

        public function __construct($db){
            $this->db = $db;
        }
        
        /**
        * Sets the filters to apply & triggers to get the records
        * @param $filters
        * return array
        */
        public function fetchRecords($filters){
            $this->filters = $filters;

            $result = $this->getRecords();

            return array (
                'success' => true,
                'results' => $result != false ? $result : $this->noRecords
            );
        }

        /**
        * Prepares the query & fetch the records
        * return array
        */
        public function getRecords(){
            // Get the sql stament
            $sql = $this->getSql();
            // Prepare the query
            $stmt = $this->db->query($sql);
            // Fetch values from PDO array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
        * Build the query
        * return string
        */
        public function getSql(){

            $sql = "SELECT * FROM {$this->table} WHERE name IS NOT NULL ";

            foreach ($this->filters as $filter) {
                foreach ($filter as $key=>$value) {
                    if($key !== 'id' && $value !== 'all'){
                        $sql .= " AND {$key} = {$value}";
                    }
                }
            }
            return $sql;
        }
    }
<?php

    class service {
        
        /**
        * Variable will contain the json response
        * @param $response
        */
        private $response;
        /**
        * Main table
        * @param $table
        */
        private $table;
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
        * Params pass in the post request
        * @param $params
        */
        private $params;
        private $paramsValues;
        /**
        * Standar message for no records
        * @param $noRecords
        */
        private $noRecords = 'No records match the search criteria';

        private $recordsAdded = 'Records added';

        public function __construct($db, $service){
            $this->db = $db;
            $this->table = $service;
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
            // Get the sql statement
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

            $sql = "SELECT * FROM {$this->table} WHERE id IS NOT NULL ";

            foreach ($this->filters as $filter) {
                foreach ($filter as $key=>$value) {
                    if($key !== 'id' && $value !== 'all'){
                        $sql .= " AND {$key} = {$value}";
                    }
                }
            }
            return $sql;
        }

        /**
        * Sets the params & triggers to get insert records
        * @param $params
        * return array
        */
        public function addRecords($paramsValues,$params){
            
            $this->params = $params;
            $this->paramsValues = $paramsValues;

            $result = $this->insertRecords();

            return array (
                'success' => true,
                'results' => $result != false ? $result : $this->noRecords
            );
        }

        /**
        * Prepares the query & fetch the records
        * return array
        */
        public function insertRecords(){
            // Get the sql statement
            $sql = $this->insertSql();
            // Prepare the query
            $stmt = $this->db->prepare($sql);

            foreach ($this->paramsValues as $key=>$value) {
                # code...
                $stmt->bindParam($this->params['columnIndexValue'][$key], $this->paramsValues[$key]);

                $array[] = $value;

            }

            // $stmt->bindParam(':name', $this->paramsValues[0]);
            // $stmt->bindParam(':role_id', $this->paramsValues[1]);
            // $stmt->bindParam(':status', $this->paramsValues[2]);
            
            $stmt->execute();
            
            return true;
             
        }

        /**
        * Build the query
        * return string
        */
        public function insertSql(){

            $columnsNames = implode(',', $this->params['column']);
            $columnsIndexValues = implode(',', $this->params['columnIndexValue']);
            $columnsValues = implode(',', $this->paramsValues);
            $sql = "INSERT INTO {$this->table} ({$columnsNames}) VALUES ({$columnsIndexValues})";
            
            return $sql;
        }
    }
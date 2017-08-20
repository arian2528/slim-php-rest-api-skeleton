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
        /**
        * Values pass in the post request
        * @param $paramsValues
        */
        private $paramsValues;
        /**
        * Values pass in the post request key:column name value:value
        * @param $requestUpdateValues
        */
        private $requestUpdateValues;
        /**
        * Values pass in the put request
        * @param $updateId
        */
        private  $updateId;
        /**
        * Standar message for no records
        * @param $noRecords
        */
        private $noRecords = 'No records match the search criteria';
        /**
        * Standar message after adding records
        * @param $recordsAdded
        */
        private $recordsAdded = 'Records added';
        /**
        * Standar message after update records
        * @param $recordsUpdated
        */
        private $recordsUpdated = 'Records updated';
        

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
                'results' => $result != false ? $this->recordsAdded : $this->noRecords
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
                $stmt->bindParam($this->params['columnNamePdo'][$key], $this->paramsValues[$key]);
            }
            
            $stmt->execute();
            
            return true;
             
        }

        /**
        * Build the query
        * return string
        */
        public function insertSql(){

            $columnNames = implode(',', $this->params['columnNames']);
            $columnNamePdo = implode(',', $this->params['columnNamePdo']);
            $columnsValues = implode(',', $this->paramsValues);
            $sql = "INSERT INTO {$this->table} ({$columnNames}) VALUES ({$columnNamePdo})";
            
            return $sql;
        }

        /**
        * Sets the params & triggers to get insert records
        * @param $params
        * return array
        */
        public function updateRecords($requestUpdateValues,$params,$id){
            
            $this->params = $params;
            $this->requestUpdateValues = $requestUpdateValues;
            $this->updateId = $id;

            $result = $this->modifyRecords();

            return $result;

            return array (
                'success' => true,
                'results' => $result != false ? $this->recordsUpdated : $this->noRecords
            );
        }

        /**
        * Prepares the query & fetch the records
        * return array
        */
        public function modifyRecords(){
            // Get the sql statement
            $sql = $this->updateSql();
            // Prepare the query
            $stmt = $this->db->prepare($sql);

            foreach ($this->requestUpdateValues as $key => $value) {
                $stmt->bindParam($this->params['columnName_Pdo'][$key], $this->requestUpdateValues[$key]);
            }
            
            $stmt->execute();
            
            return true;
             
        }

        /**
        * Build the query
        * return string
        */
        public function updateSql(){

            $sql = "UPDATE {$this->table} SET ";
            $i = 0;
            $size = sizeof($this->requestUpdateValues);

            foreach ($this->requestUpdateValues as $key=>$value) {
                $sql .= "{$key} = {$this->params['columnName_Pdo'][$key]} ";
                
                $i++;
                
                if($i < $size) { $sql .= ' , '; }
                
            }

            $sql .= " WHERE id = {$this->updateId} ";
            
            return $sql;
        }

    }
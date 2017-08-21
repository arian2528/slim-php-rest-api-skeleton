<?php

    class sqlQuery {

        /**
        * Main table
        * @param $table
        */
        private $table;
        /**
        * Main service requested
        * @param $service
        */
        private $service;
        /**
        * Filters applied to the query
        * @param $filters
        */
        private $filters;
        
        public function __construct($service){
            $this->service = $service;
        }
        
        /**
        * Switch the service required to pull the query
        * return string
        */
        public function getSql($filters){

            $this->filters = $filters;

            switch ($this->service) {
                case 'languages' :
                    $sql = $this->languageQuery();
                    break;
                case 'roles' :
                    $sql = $this->rolesQuery();
                    break;
            }

            return $sql;
        }

        /**
        * Build the language query
        * return string
        */

        // TODO: Make dynamic the conditions addon

        private function languageQuery(){
            $sql = "SELECT l.id,l.name,l.status,r.name as role 
                        FROM languages AS l 
                        LEFT JOIN roles AS r ON r.id = l.role_id 
                        WHERE l.id IS NOT NULL";

            foreach ($this->filters as $filter) {
                foreach ($filter as $key=>$value) {
                    if($key !== 'id' && $value !== 'all'){
                        $sql .= " AND l.{$key} = {$value}";
                    }
                }
            }

            return $sql;
        }

        private function rolesQuery(){
            $sql = "SELECT id, name, status 
                        FROM  roles 
                        WHERE id IS NOT NULL";

            foreach ($this->filters as $filter) {
                foreach ($filter as $key=>$value) {
                    if($key !== 'id' && $value !== 'all'){
                        $sql .= " AND {$key} = {$value}";
                    }
                }
            }

            return $sql;
        }


        // Example 

        // $sql = "SELECT * FROM {$this->table} WHERE id IS NOT NULL ";

        //     foreach ($this->filters as $filter) {
        //         foreach ($filter as $key=>$value) {
        //             if($key !== 'id' && $value !== 'all'){
        //                 $sql .= " AND {$key} = {$value}";
        //             }
        //         }
        //     }
        //     return $sql;

    }
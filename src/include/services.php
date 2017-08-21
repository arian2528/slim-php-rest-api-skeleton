<?php

    class services {

        private $service;

        public function __construct($service){
            $this->service = $service;
        }

        public function getParams(){
            
            switch ($this->service) {
                case 'languages':
                    $relation = array(
                        'table' => 'roles',
                        'column' => 'role_id',
                        'type' => 1
                    );
                    $columnNames = ['name','role_id','status'];
                    $columnNamePdo = [':name',':role_id',':status'];
                    $columnName_Pdo = array(
                        'name' => ':name',
                        'role_id' => ':role_id',
                        'status' => ':status'
                    );
                    break;
                
                default:
                    # code...
                    break;
            }
            
            return array(
                'columnNames' => $columnNames,
                'columnNamePdo' => $columnNamePdo,
                'columnName_Pdo' => $columnName_Pdo,
                'relation' => $relation
            );
        }

    }
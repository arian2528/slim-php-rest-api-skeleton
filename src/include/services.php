<?php

    class services {

        private $service;

        public function __construct($service){
            $this->service = $service;
        }

        public function getParams(){
            
            switch ($this->service) {
                case 'languages':
                    # code...
                    $columnsNames = ['name','role_id','status'];
                    $columnsIndexvalues = [':name',':role_id',':status'];
                    break;
                
                default:
                    # code...
                    break;
            }
            
            return array(
                'column' => $columnsNames,
                'columnIndexValue' => $columnsIndexvalues
            );
        }

    }
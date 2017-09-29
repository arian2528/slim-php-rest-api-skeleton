<?php
    
    namespace Models;
    use Models\services as services;
    
    class routeController {
        /**
        * The result array
        * @param $result
        */
        public $result;

        public $errorMsg;
        
        public $service;

        public function __construct($service){
            
            $this->result = array ('success' => false);
            $this->errorMsg = [];
            $this->service = $service;

        }

        public function getParams(){
            $services = new services($this->service);
            return $services->getParams();
        }

    }
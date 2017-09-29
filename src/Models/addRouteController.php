<?php

    namespace Models;
    use Models\database as database;
    use Models\factory as factory;
    
    class addRouteController extends routeController {

        /**
        * Variable will contain the http request
        * @param $params
        */
        public $params = false;
        /**
        * The values pass in the request
        * @param $requestParamsValues
        */
        public $requestParamsValues;

        public function __construct($service){
            parent::__construct($service);
            $this->params = $this->getParams();
        }

        /**
        * Check if the params were included in the request
        */
        private function verifyRequestParams(){
            return $this->requestParamsValues !== null && sizeof($this->requestParamsValues) > 0 ? true : false;
        }
        
        /**
        * Get's the response
        * return array
        */
        public function getResponse($requestParamsValues){
            $this->requestParamsValues = $requestParamsValues;
           
            if($this->verifyRequestParams() === false){
                $this->errorMsg = array ('error' => 'Missing params in the request');
                $response = array_merge($this->result,$this->errorMsg); 
            }else{
                
                try{
                    // Establish connection with DB
                    $factory = new factory(new database);
                    // Sets the service required
                    $item = $factory->create($this->service);
                    // Add the records
                    $response = $item->addRecords($this->requestParamsValues,$this->params);

                } catch(PDOException $e){
                    $response = array (
                            'success' => false,
                            'error' => ''.$e->getMessage().''
                    );
                }
            }
            
            return $response;
        }

    }
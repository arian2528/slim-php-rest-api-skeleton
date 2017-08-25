<?php

    class fecthRouteController extends routeController {

        /**
        * Variable will contain the http request
        * @param $params
        */
        public $params = false;

        public $filters = false;

        public $requestParams;

        public function __construct($service,$requestParams){
            
            $this->requestParams = $requestParams;
            parent::__construct($service);

            // No need for this, keep it here until update and add routes are added
            //$this->params = $this->getParams();
        }

        private function verifyRequestParams(){
            
            if(isset($this->requestParams) && $this->requestParams != '' ){
                $this->params = explode('/', $this->requestParams);
                // Build the filters params for the query
                if(isset($this->params) && sizeof($this->params) > 0){
                    foreach ($this->params as $param) {
                        $param = explode(':',$param);
                        $this->filters[] = array($param[0] => $param[1] );
                    }
                }
            }

            return $this->filters;

        }
        
        
        /**
        * Get's the response
        * return array
        */
        public function getResponse(){
            
            if($this->verifyRequestParams() === false){
                $this->errorMsg = array ('error' => 'Missing params in the request');
                $response = array_merge($this->result,$this->errorMsg); 
            }else{
                
                try{
                    // Establish connection with DB
                    $factory = new factory(new Database);
                    // Sets the service required
                    $item = $factory->create($this->service);
                    // Fetch the records
                    $response = $item->fetchRecords($this->filters,$this->params);

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
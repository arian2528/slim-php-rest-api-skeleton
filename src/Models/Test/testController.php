<?php namespace Models\Test;
    
    class testController extends routeController {
        
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


    }
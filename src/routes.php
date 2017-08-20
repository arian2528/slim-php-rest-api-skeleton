<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// App landing page

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

// Instructions

$app->get('/api/instructions', function (Request $request, Response $response) {
    // Log request
    $this->logger->info("Slim-REst-API'/api/instructions' route");
    $instructions = array(
        'Title' => 'API Instructions',
        'Description' => 'Description'
    );
    return json_encode($instructions);
});

// Example
// http://server.net/api/languages/fetch/role_id:1

// Fetch services
$app->get('/api/{service}/fetch[/{params:.*}]', function(Request $request, Response $response){
    // default response
    $result = array (
            'success' => false
    );
    $params = [];
    $errorMsg = [];
    
    // Log request
    $this->logger->info("Slim-REst-API'/api/fetch' route");
    // Get's the attributes from the url
    $service = $request->getAttribute('service');
    $requestParams = $request->getAttribute('params');
    if(isset($requestParams) && $requestParams != '' ){
        $params = explode('/', $request->getAttribute('params'));
    }
    // Build the filters params for the query
    if(isset($params) && sizeof($params) > 0){
        foreach ($params as $param) {
            $param = explode(':',$param);
            $filters[] = array($param[0] => $param[1] );
        }
    }else{
        $errorMsg = array ('error' => 'Missing params in the request');
        $result = array_merge($result,$errorMsg);
        return json_encode($result);
    }
    
    try{
        // Establish connection with DB
        $factory = new factory(new Database);
        // Sets the service required
        $item = $factory->create($service);
        // Fetch the records
        $result = $item->fetchRecords($filters);

    } catch(PDOException $e){
        $result = array (
                'success' => false,
                'error' => ''.$e->getMessage().''
        );
        
    }
    
    return json_encode($result);

});

// Insert services

$app->post('/api/{service}/add', function(Request $request, Response $response){
   
    // default response
    $result = array (
            'success' => false
    );
    $params = [];
    $errorMsg = [];
    
    // Log request
    $this->logger->info("Slim-REst-API'/api/add' route");

    // Get's the attributes from the url
    $service = $request->getAttribute('service');

    $services = new services($service);

    $params = $services->getParams();

    foreach ($params['columnNames'] as $param) {
        $requestParamsValues[] = $request->getParam($param);
    }

    try{
        // Establish connection with DB
        $factory = new factory(new Database);
        // Sets the service required
        $item = $factory->create($service);
        // Add the records
        $result = $item->addRecords($requestParamsValues,$params);

    } catch(PDOException $e){
        $result = array (
                'success' => false,
                'error' => ''.$e->getMessage().''
        );
    }

    return json_encode($result);
});

// Update Customer
$app->put('/api/{service}/update/{id}', function(Request $request, Response $response){
    
    // default response
    $result = array (
            'success' => false
    );
    $params = [];
    $errorMsg = [];
    
    // Log request
    $this->logger->info("Slim-REst-API'/api/add' route");

    // Get's the attributes from the url
    $service = $request->getAttribute('service');
    $id = $request->getAttribute('id');
    
    $services = new services($service);

    $params = $services->getParams();

    foreach ($params['columnNames'] as $param) {
        if($request->getParam($param) !== null){
            $requestParamsValues[] = $request->getParam($param);
            $requestUpdateValues[$param] = $request->getParam($param);
        }
        
    }
    
    try{
        // Establish connection with DB
        $factory = new factory(new Database);
        // Sets the service required
        $item = $factory->create($service);
        // Add the records
        $result = $item->updateRecords($requestUpdateValues,$params,$id);

    } catch(PDOException $e){
        $result = array (
                'success' => false,
                'error' => ''.$e->getMessage().''
        );
    }

    return json_encode($result);

});

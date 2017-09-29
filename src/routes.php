<?php

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    use Models\fecthRouteController as fecthRouteController;


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
        // Log request
        $this->logger->info("Slim-REst-API'/api/fetch' route");

        // Get's the attributes from the url
        $service = $request->getAttribute('service');
        $requestParams = $request->getAttribute('params');
        
        $fecthRouteController = new fecthRouteController($service,$requestParams);
        $response = $fecthRouteController->getResponse();
        return json_encode($response);

    });

    // Insert services

    $app->post('/api/{service}/add', function(Request $request, Response $response){
    
        // Log request
        $this->logger->info("Slim-REst-API'/api/add' route");

        // Get's the attributes from the url
        $service = $request->getAttribute('service');
        
        $addRouteController = new addRouteController($service);

        foreach ($addRouteController->params['columnNames'] as $param) {
            if($request->getParam($param)){
               $requestParamsValues[] = $request->getParam($param); 
            }
        }
        
        $response = $addRouteController->getResponse($requestParamsValues);
        return json_encode($response);

    });

    // Update Customer
    $app->post('/api/{service}/update', function(Request $request, Response $response){
        
        // default response
        $result = array ( 'success' => false );
        $params = [];
        $errorMsg = [];
        
        // Log request
        $this->logger->info("Slim-REst-API'/api/update' route");

        // Get's the attributes from the url
        $service = $request->getAttribute('service');
        // $id = $request->getAttribute('id');
        $ids = $request->getParam('id');
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
            $result = $item->updateRecords($requestUpdateValues,$params,$ids);

        } catch(PDOException $e){
            $result = array (
                    'success' => false,
                    'error' => ''.$e->getMessage().''
            );
        }

        return json_encode($result);

    });











    // Delete Customer
    $app->delete('/api/{service}/delete/{id}', function(Request $request, Response $response){
        // default response
        $result = array ( 'success' => false );
        $params = [];
        $errorMsg = [];
        
        // Log request
        $this->logger->info("Slim-REst-API'/api/delete' route");

        // Get's the attributes from the url
        $service = $request->getAttribute('service');
        $id = $request->getAttribute('id');

        try{
            // Establish connection with DB
            $factory = new factory(new Database);
            // Sets the service required
            $item = $factory->create($service);
            // Add the records
            $result = $item->deleteRecords($id);

        } catch(PDOException $e){
            $result = array (
                    'success' => false,
                    'error' => ''.$e->getMessage().''
            );
        }

    });

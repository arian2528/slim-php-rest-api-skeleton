<?php

namespace Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

// Use the application settings
// $settings = require __DIR__ . '/../../src/settings.php';

// Instantiate the application
// $app = new App($settings);

// Setting up classes
require __DIR__ . '/../../src/include/database.php';
require __DIR__ . '/../../src/include/factory.php';
require __DIR__ . '/../../src/include/service.php';

class ServiceTestClass extends \PHPUnit_Framework_TestCase
{
    

    public function testFetchRouteEmptyParams()
    {
        $service = 'languages';
        // Establish connection with DB
        $factory = new factory(new Database);
        // Sets the service required
        $serviceObject = $factory->create($service);
        
        $response = $serviceObject->getSql();
        
        $assertion = "SELECT * FROM {$service} WHERE id IS NOT NULL ";

        $this->assertContains($assertion, (string)$response);
    }
}


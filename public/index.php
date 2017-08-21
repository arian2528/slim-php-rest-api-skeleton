<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

// Reading the .env variables
if(getenv('DB_HOST') === null || getenv('DB_HOST') == '' ){
    $dotenv = new Dotenv\Dotenv('../');
    $dotenv->load(); 
}

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Setting up classes
require __DIR__ . '/../src/include/database.php';
require __DIR__ . '/../src/include/factory.php';
require __DIR__ . '/../src/include/sqlQuery.php';
require __DIR__ . '/../src/include/service.php';
require __DIR__ . '/../src/include/services.php';


// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();

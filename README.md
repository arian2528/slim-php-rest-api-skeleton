# Slim Framework 3 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    run: composer create-project  slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can also run this command. 

	run: composer start

Run this command to run the test suite

	run: composer test

That's it! Now go build something cool.

## Setting the app enviroment

For setting your .env variables

run: composer require vlucas/phpdotenv

Desc: https://packagist.org/packages/vlucas/phpdotenv

Create .env and .env.example files
Add .env to .gitignore
Call the Dotenv class on index.php
Tip: Add local env variables on .env file,

Follow this after you create your Heroku app
If using Heroku, set your env variables on applications/settings
Click on Config Variables. Add each variable as key=value
access the variables in your code like this : getenv('KEY_NAME');
https://stackoverflow.com/questions/21592832/use-heroku-config-vars-with-php

## Setting up autoloader with psr-4

Create a folder for the classes inside src, named Models
Add psr4-autoloading to the composer.json as a autoload property in the json
Require autoload.php on index.php
Desc: https://www.youtube.com/watch?v=VGSerlMoIrY
Extra: https://www.youtube.com/watch?v=t3SvDAoODr8

Remmember to add slash before PDO 
Desc : https://stackoverflow.com/questions/13426252/pdo-out-of-scope-php-composer

## Setting up the db connection

Create a file named database.php inside Models folder
Design pattern: Singleton
run composer dump-autoload -o after a new class is added.

## Customize the REst API part

Modify the src/routes.php file
Use Psr for handling Request/Response
Add middleware to filter only specific request

## Create the factory class

Create src/include/factory.php
Create a class to intantiate other classes depending the service requested.
Design pattern: Factory

## Add routes for CRUD functionality

Create Fetch route to handling fetch data request
Create Post route to insert new records
Create Put route to update records
Create Delete route to delete records

# Add dynamic classes

Create Services class to where the relation between the tables will be set. 
The model of the tables are set in this class.
Create Service class, controller for all route request.
Create sqlQuery class for custom sql querys.
 
## Deploy to Heroku

Create a Procfile in the root directory

run: heroku login
run: heroku create

This will create the app on Heroku

run: git push heroku master



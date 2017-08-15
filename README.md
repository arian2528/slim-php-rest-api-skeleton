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



## Customize the REst API part
<?php

require '../vendor/autoload.php';

// Set up environment variables
$dotenv = \Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

// Now environment variables are available via $_ENV, $_SERVER or dotenv (through Slim container)

$settings = require '../src/settings.dev.php';
$app = new \Slim\App($settings);

require '../src/dependencies.php';

require '../src/routes.php';

$app->run();

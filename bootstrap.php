<?php

/* Initialises the application. */
require 'vendor/autoload.php';

/* Set paths */
Flight::set('path.root', __DIR__);
Flight::set('path.public', __DIR__ . '/public');
Flight::set('path.src', __DIR__ . '/src');
Flight::set('path.views', __DIR__ . '/src/views');
Flight::set('path.res', __DIR__ . '/src/public/res');

/* Include paths */
Flight::path(__DIR__ . '/src/controllers');
Flight::path(__DIR__ . '/src/rsr');
Flight::path(__DIR__ . '/src/rsr/io');
// Flight::path(__DIR__ . '/src/models');

/* Twig initial setup. */
$loader = new Twig_Loader_Filesystem(Flight::get('path.views'));
$twigConfig = array(
    // 'cache' => '__DIR__ . '/data/cache',
    // 'cache' => false,
    'debug'	=> true
);

Flight::register('view', 'Twig_Environment', array($loader, $twigConfig), function($twig) {
    $twig->addExtension(new Twig_Extension_Debug()); // Add the debug extension
});

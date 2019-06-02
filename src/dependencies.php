<?php

/* Set up dependencies for the Slim App.
 * See http://www.slimframework.com/docs/v3/concepts/di.html
 */

use \Psr\Container\ContainerInterface as Container;

$container = $app->getContainer();

/* Twig renderer */
$container['view'] = function(Container $container) {
    $settings = $container->get('settings');

    $view = new \Slim\Views\Twig($settings['view']['templatePath'], [
        'cache' => $settings['view']['cache']
    ]);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

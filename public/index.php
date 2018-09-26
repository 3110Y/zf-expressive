<?php

declare(strict_types=1);
error_reporting (E_ALL);
date_default_timezone_set('Europe/Moscow');
// Delegate static file requests back to the PHP built-in webServer
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}
$DR   =  dirname(__DIR__);
chdir($DR);
require 'vendor/autoload.php';

use Core\Dir\Dir;

/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
(function () use ($DR) {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require 'config/container.php';
    $dir = $container->get(Dir::class);
    $dir->setDR($DR);
    /** @var \Zend\Expressive\Application $app */
    $app = $container->get(\Zend\Expressive\Application::class);
    $factory = $container->get(\Zend\Expressive\MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require 'config/pipeline.php')($app, $factory, $container);
    (require 'config/routes.php')($app, $factory, $container);

    $app->run();
})();

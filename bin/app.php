<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 27.04.18
 * Time: 14:13
 */

declare(strict_types=1);

use Core\Dir\Dir;
use Environment\Basic\ConsoleRunnerFactory;
use Symfony\Component\Console\Application;

error_reporting (E_ALL);
date_default_timezone_set('Europe/Moscow');
$DR    =  dirname(__DIR__);
chdir($DR);
require 'vendor/autoload.php';


$container = require 'config/container.php';
/** @var Core\Dir\Dir $dir */
$dir = $container->get(Dir::class);
$dir->setDR($DR);

$cli = new Application('Application console');

$cli->setHelperSet($container->get(ConsoleRunnerFactory::class));

Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $cli->add($container->get($command));
}

$cli->run();

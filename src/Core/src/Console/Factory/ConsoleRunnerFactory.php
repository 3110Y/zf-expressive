<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 23.07.18
 * Time: 19:36
 */

namespace Console\Factory;


use Core\EntityManager\Factory\EntityManagerFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Psr\Container\ContainerInterface;

class ConsoleRunnerFactory
{
    public  function __invoke(ContainerInterface $container)
    {
        return ConsoleRunner::createHelperSet($container->get(EntityManagerFactory::class));
    }
}


<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 17.09.18
 * Time: 18:48
 */

namespace Logger;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class LoggerFactory
{
    /**
     * @param ContainerInterface $container
     * @return Logger
     * @throws \Exception
     */
    public  function __invoke(ContainerInterface $container)
    {
        $logger = new Logger('App');
        $logger->pushHandler(new StreamHandler(
            'file/log/application.log',
            $container->get('debug') ? Logger::DEBUG : Logger::WARNING
        ));
        return $logger;
    }
}
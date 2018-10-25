<?php
/**
 * Created by PhpStorm.
 * User: gaevoy
 * Date: 27.09.18
 * Time: 14:34
 */

namespace Core\EntityManager\Factory;


use Core\Dir\Dir;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

class EntityManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public  function __invoke(ContainerInterface $container)
    {
        $dir    =   $container->get(Dir::class);
        $DR     =   $dir->getDR();
        $path   =   $DR . 'src';
        $entities =   [];
        $resource = opendir($path);
        if (false !== $resource) {
            while ($dir = readdir($resource)) {
                $entity = $path . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'Entity';
                if ($dir !== '.' && $dir !== '..' && is_dir($entity)) {
                    $entities[] = $entity;
                }
            }
        }

        $config = Setup::createAnnotationMetadataConfiguration($entities, $container->get('config')['debug']);

        $cache = new \Doctrine\Common\Cache\ArrayCache;
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        $reader = new AnnotationReader();
        $driverImpl = new AnnotationDriver($reader, $entities);
        $config->setMetadataDriverImpl($driverImpl);

        // Create event manager and hook prefered extension listeners
        $evm = new EventManager();
        // gedmo extension listeners
        $entityManager = EntityManager::create($container->get('config')['connection'], $config, $evm);
        return $entityManager;
    }
}
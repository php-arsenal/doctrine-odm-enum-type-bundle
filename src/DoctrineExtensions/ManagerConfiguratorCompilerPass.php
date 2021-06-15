<?php

namespace PhpArsenal\DoctrineODMEnumTypeBundle\DoctrineExtensions;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ManagerConfiguratorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->setParameter('doctrine_mongodb.odm.manager_configurator.class', ManagerConfigurator::class);
    }
}

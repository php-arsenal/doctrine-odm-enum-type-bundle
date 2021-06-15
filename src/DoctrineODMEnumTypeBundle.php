<?php

namespace PhpArsenal\DoctrineODMEnumTypeBundle;

use PhpArsenal\DoctrineODMEnumTypeBundle\DoctrineExtensions\ManagerConfiguratorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DoctrineODMEnumTypeBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ManagerConfiguratorCompilerPass());
    }
}

<?php

namespace PhpArsenal\DoctrineODMEnumTypeBundle\DependencyInjection;

use MyCLabs\Enum\Enum;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class DoctrineODMEnumTypeExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // TODO: Implement load() method.
    }

    public function prepend(ContainerBuilder $container)
    {
        $kernelClass = array_values(array_filter($container->getServiceIds(), function (string $serviceId) {
            return str_ends_with($serviceId, '\\Kernel');
        }))[0];
        [$projectNamespace] = explode('\\Kernel', $kernelClass);

        $enumClasses = array_values(array_filter(get_declared_classes(), function (string $declaredClass) use ($projectNamespace) {
            return str_starts_with($declaredClass, "$projectNamespace\\") && strpos($declaredClass, 'Enum') > 0 && is_subclass_of($declaredClass, Enum::class);
        }));
        $enumClasses = array_filter($enumClasses);

        if(!empty($enumClasses)) {
            $container->prependExtensionConfig('doctrine_mongodb', [
                'type' => array_map(function (string $enumClass) {
                    return [
                        'name' => $enumClass,
                        'class' => $enumClass,
                    ];
                }, $enumClasses),
            ]);
        }
    }
}

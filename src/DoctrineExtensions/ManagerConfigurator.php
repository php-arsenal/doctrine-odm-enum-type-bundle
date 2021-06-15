<?php

namespace PhpArsenal\DoctrineODMEnumTypeBundle\DoctrineExtensions;

use MyCLabs\Enum\Enum;
use PhpArsenal\DoctrineODMEnumTypeBundle\MappingTypes\PhpEnumType;

class ManagerConfigurator extends \Doctrine\Bundle\MongoDBBundle\ManagerConfigurator
{
    public static function loadTypes(array $types): void
    {
        foreach($types as $i => $type) {
            if($type['class'] && is_subclass_of($type['class'], Enum::class)) {
                PhpEnumType::registerEnumType($type['class']);
                unset($types[$i]);
            }
        }

        parent::loadTypes($types);
    }
}

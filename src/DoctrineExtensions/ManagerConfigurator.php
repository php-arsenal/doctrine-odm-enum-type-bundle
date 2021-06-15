<?php

namespace PhpArsenal\DoctrineODMEnumTypeBundle\DoctrineExtensions;

class ManagerConfigurator extends \Doctrine\Bundle\MongoDBBundle\ManagerConfigurator
{
    public static function loadTypes(array $types): void
    {
        parent::loadTypes($types);

        // todo: get all enums
//        PhpEnumType::registerEnumType(OrderStageEnum::class);
    }
}

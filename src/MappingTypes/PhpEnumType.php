<?php

namespace PhpArsenal\DoctrineODMEnumTypeBundle\MappingTypes;

use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use MyCLabs\Enum\Enum;
use Psr\Log\InvalidArgumentException;

class PhpEnumType extends Type
{
    use ClosureToPHP;

    private string $name;
    protected string $enumClass = Enum::class;

    public function getName(): string
    {
        return $this->name ?: 'enum';
    }

    /**
     * @throws InvalidArgumentException
     */
    public function convertToPHPValue($value)
    {
        if ($value === null) {
            return null;
        }

        if (method_exists($this->enumClass, 'castValueIn')) {
            $castValueIn = [$this->enumClass, 'castValueIn'];
            $value = $castValueIn($value);
        }

        $isValidCallable = [$this->enumClass, 'isValid'];
        $isValid = $isValidCallable($value);
        if (!$isValid) {
            $toArray = [$this->enumClass, 'toArray'];
            throw new InvalidArgumentException(sprintf(
                'The value "%s" is not valid for the enum "%s". Expected one of ["%s"]',
                $value,
                $this->enumClass,
                implode('", "', $toArray()),
            ));
        }

        return new $this->enumClass($value);
    }

    public function convertToDatabaseValue($value)
    {
        if ($value === null) {
            return null;
        }

        if (method_exists($this->enumClass, 'castValueOut')) {
            $castValueOut = [$this->enumClass, 'castValueOut'];
            return $castValueOut($value);
        }

        return (string)$value;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function registerEnumType(string $typeNameOrEnumClass, ?string $enumClass = null): void
    {
        $typeName = $typeNameOrEnumClass;
        $enumClass = $enumClass ?: $typeNameOrEnumClass;

        if (!is_subclass_of($enumClass, Enum::class)) {
            throw new InvalidArgumentException(sprintf(
                'Provided enum class "%s" is not valid. Enums must extend "%s"',
                $enumClass,
                Enum::class,
            ));
        }

        if(self::hasType($typeName)) {
            self::overrideType($typeName, static::class);
        }
        else {
            self::addType($typeName, static::class);
        }

        /** @var PhpEnumType $type */
        $type = self::getType($typeName);
        $type->name = $typeName;
        $type->enumClass = $enumClass;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function registerEnumTypes(array $types): void
    {
        foreach ($types as $typeName => $enumClass) {
            $typeName = is_string($typeName) ? $typeName : $enumClass;
            static::registerEnumType($typeName, $enumClass);
        }
    }
}

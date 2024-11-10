<?php

declare(strict_types=1);

namespace App\Doctrine\Enum;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use ReflectionClass;

abstract class EnumType extends Type
{
    abstract public function getEnum(): string;

    public function isNullable(): bool
    {
        return false;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $enumClass = $this->getEnum();

        if (true === method_exists($enumClass, 'cases')) {
            $enumValues = implode(', ', array_map(fn ($case) => "'$case->value'", $enumClass::cases()));
        }

        return sprintf('ENUM(%s)', $enumValues ?? []);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
    {
        $enumClass = $this->getEnum();

        if (false === enum_exists($enumClass)) {
            throw new InvalidArgumentException("Class $enumClass is not an enum.");
        }

        if (null !== $value && true === method_exists($enumClass, 'from')) {
            return $enumClass::from($value);
        }

        if (null === $value && false === $this->isNullable()) {
            throw new InvalidArgumentException('This enum is not nullable.');
        }

        return null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        $enumClass = $this->getEnum();

        if (false === is_a($value, $enumClass)) {
            throw new InvalidArgumentException(sprintf('Invalid %s value', $this->getName()));
        }

        return (string) $value->value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return sprintf('enum%s', (new ReflectionClass(static::class))->getShortName());
    }
}

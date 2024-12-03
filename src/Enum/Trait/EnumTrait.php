<?php

declare(strict_types=1);

namespace App\Enum\Trait;

use UnitEnum;

trait EnumTrait
{
    public static function getName(int $value, string $capitalize = 'lowercase'): string
    {
        $enum = self::from($value);

        return match ($capitalize) {
            'uppercase' => strtoupper(string: $enum->name),
            'lowercase' => strtolower(string: $enum->name),
            'capitalize' => ucwords(string: $enum->name),
            default => $enum->name
        };
    }

    public static function getNames(string $capitalize = 'lowercase'): array
    {
        return array_map(
            fn (UnitEnum $enum) => match ($capitalize) {
                'uppercase' => strtoupper(string: $enum->name),
                'lowercase' => strtolower(string: $enum->name),
                'capitalize' => ucwords(string: $enum->name),
                default => $enum->name
            },
            self::cases()
        );
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), 'values');
    }

    public static function fromName(string $name): ?static
    {
        return array_find(self::cases(), fn (UnitEnum $enum) => mb_strtolower($enum->name) === mb_strtolower($name));
    }
}

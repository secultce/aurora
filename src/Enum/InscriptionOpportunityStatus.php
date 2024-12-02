<?php

declare(strict_types=1);

namespace App\Enum;

use InvalidArgumentException;

enum InscriptionOpportunityStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case SUSPENDED = 3;

    public static function fromValueOrLabel(int|string $value): self
    {
        if (true === is_string($value)) {
            return self::fromLabel($value);
        }

        return self::from($value);
    }

    public static function fromLabel(string $label): self
    {
        return match ($label) {
            'active' => self::ACTIVE,
            'inactive' => self::INACTIVE,
            'suspended' => self::SUSPENDED,
            default => throw new InvalidArgumentException("Invalid label: $label"),
        };
    }

    public static function getLabels(): array
    {
        return array_map(fn (self $case) => strtolower($case->name), self::cases());
    }

    public static function getLabelByValue(int $value): string
    {
        $item = self::from($value);

        return strtolower($item->name);
    }
}

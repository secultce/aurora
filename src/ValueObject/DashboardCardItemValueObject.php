<?php

declare(strict_types=1);

namespace App\ValueObject;

class DashboardCardItemValueObject
{
    public function __construct(
        public string $icon,
        public int $quantity,
        public string $text
    ) {
    }
}

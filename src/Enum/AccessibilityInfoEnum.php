<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\EnumTrait;

enum AccessibilityInfoEnum: int
{
    use EnumTrait;

    case YES = 1;
    case NO = 2;
    case NOT_INFORMED = 3;
}

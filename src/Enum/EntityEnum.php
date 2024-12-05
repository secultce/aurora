<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\EnumTrait;

enum EntityEnum: int
{
    use EnumTrait;

    case AGENT = 1;
    case EVENT = 2;
    case INITIATIVE = 3;
    case SPACE = 4;
    case OPPORTUNITY = 5;
    case ORGANIZATION = 6;
}

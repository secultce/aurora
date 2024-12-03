<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\EnumTrait;

enum InscriptionOpportunityStatusEnum: int
{
    use EnumTrait;

    case ACTIVE = 1;
    case INACTIVE = 2;
    case SUSPENDED = 3;
}

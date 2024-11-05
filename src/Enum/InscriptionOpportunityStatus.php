<?php

declare(strict_types=1);

namespace App\Enum;

enum InscriptionOpportunityStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
}

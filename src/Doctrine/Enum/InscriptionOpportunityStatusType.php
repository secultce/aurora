<?php

declare(strict_types=1);

namespace App\Doctrine\Enum;

use App\Enum\InscriptionOpportunityStatus;

class InscriptionOpportunityStatusType extends EnumType
{
    public function getEnum(): string
    {
        return InscriptionOpportunityStatus::class;
    }
}

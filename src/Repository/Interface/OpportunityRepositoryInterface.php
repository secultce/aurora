<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\Opportunity;

interface OpportunityRepositoryInterface
{
    public function save(Opportunity $opportunity): Opportunity;
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Opportunity;
use Doctrine\Persistence\ManagerRegistry;

class OpportunityRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opportunity::class);
    }
}

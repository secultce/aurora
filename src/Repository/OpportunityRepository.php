<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Opportunity;
use App\Repository\Interface\OpportunityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class OpportunityRepository extends AbstractRepository implements OpportunityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opportunity::class);
    }

    public function save(Opportunity $opportunity): Opportunity
    {
        $this->getEntityManager()->persist($opportunity);
        $this->getEntityManager()->flush();

        return $opportunity;
    }
}

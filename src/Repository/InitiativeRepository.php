<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Initiative;
use App\Repository\Interface\InitiativeRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class InitiativeRepository extends AbstractRepository implements InitiativeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Initiative::class);
    }

    public function save(Initiative $initiative): Initiative
    {
        $this->getEntityManager()->persist($initiative);
        $this->getEntityManager()->flush();

        return $initiative;
    }
}

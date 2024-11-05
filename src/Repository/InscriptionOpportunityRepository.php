<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\InscriptionOpportunity;
use App\Repository\Interface\InscriptionRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class InscriptionOpportunityRepository extends AbstractRepository implements InscriptionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionOpportunity::class);
    }
}

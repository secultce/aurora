<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Initiative;
use Doctrine\Persistence\ManagerRegistry;

class InitiativeRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Initiative::class);
    }
}

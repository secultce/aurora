<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Phase;
use App\Repository\Interface\PhaseRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class PhaseRepository extends AbstractRepository implements PhaseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phase::class);
    }
}

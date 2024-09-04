<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Space;
use App\Repository\Interface\SpaceRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class SpaceRepository extends AbstractRepository implements SpaceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Space::class);
    }
}

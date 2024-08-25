<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Space;
use Doctrine\Persistence\ManagerRegistry;

class SpaceRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Space::class);
    }
}

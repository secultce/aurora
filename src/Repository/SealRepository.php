<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Seal;
use App\Repository\Interface\SealRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class SealRepository extends AbstractRepository implements SealRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seal::class);
    }

    public function save(Seal $seal): Seal
    {
        $this->getEntityManager()->persist($seal);
        $this->getEntityManager()->flush();

        return $seal;
    }
}

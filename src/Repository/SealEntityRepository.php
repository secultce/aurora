<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SealEntity;
use App\Repository\Interface\SealEntityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class SealEntityRepository extends AbstractRepository implements SealEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SealEntity::class);
    }

    public function save(SealEntity $sealEntity): SealEntity
    {
        $this->getEntityManager()->persist($sealEntity);
        $this->getEntityManager()->flush();

        return $sealEntity;
    }
}

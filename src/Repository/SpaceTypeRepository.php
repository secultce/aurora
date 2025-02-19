<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SpaceType;
use App\Repository\Interface\SpaceTypeRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class SpaceTypeRepository extends AbstractRepository implements SpaceTypeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpaceType::class);
    }

    public function save(SpaceType $spaceType): SpaceType
    {
        $this->getEntityManager()->persist($spaceType);
        $this->getEntityManager()->flush();

        return $spaceType;
    }

    public function remove(SpaceType $spaceType): void
    {
        $this->getEntityManager()->remove($spaceType);
        $this->getEntityManager()->flush();
    }
}

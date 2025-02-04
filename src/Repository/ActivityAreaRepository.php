<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ActivityArea;
use App\Repository\Interface\ActivityAreaRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class ActivityAreaRepository extends AbstractRepository implements ActivityAreaRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityArea::class);
    }

    public function save(ActivityArea $activityArea): ActivityArea
    {
        $this->getEntityManager()->persist($activityArea);
        $this->getEntityManager()->flush();

        return $activityArea;
    }

    public function remove(ActivityArea $activityArea): void
    {
        $this->getEntityManager()->remove($activityArea);
        $this->getEntityManager()->flush();
    }
}

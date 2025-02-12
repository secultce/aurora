<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EventActivity;
use App\Repository\Interface\EventActivityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class EventActivityRepository extends AbstractRepository implements EventActivityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventActivity::class);
    }

    public function save(EventActivity $eventActivity): EventActivity
    {
        $this->getEntityManager()->persist($eventActivity);
        $this->getEntityManager()->flush();

        return $eventActivity;
    }

    public function remove(EventActivity $eventActivity): void
    {
        $this->getEntityManager()->remove($eventActivity);
        $this->getEntityManager()->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use App\Repository\Interface\EventRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends AbstractRepository implements EventRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $event): Event
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();

        return $event;
    }
}

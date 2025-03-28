<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use App\Entity\InscriptionEvent;
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

    public function findByAgent(string $agentId): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->from(Event::class, 'e')
            ->join(InscriptionEvent::class, 'ie', 'WITH', 'ie.event = e.id')
            ->where('ie.agent = :agentId')
            ->setParameter('agentId', $agentId)
            ->orderBy('e.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}

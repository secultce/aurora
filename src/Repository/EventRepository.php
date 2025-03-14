<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use App\Repository\Interface\EventRepositoryInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use MongoDB\Collection;

class EventRepository extends AbstractRepository implements EventRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findByFilters(array $filters, array $order = [], int $limit = 50): array
    {
        $qb = $this->createQueryBuilder('e');
        if (isset($filters['name'])) {
            $qb->andWhere('lower(e.name) LIKE lower(:name)')
                ->setParameter('name', "%{$filters['name']}%");
        }
        unset($filters['name']);

        if (isset($filters['period'])) {
            $qb->leftJoin('e.eventSchedules', 'es')
                ->andWhere('es.startHour BETWEEN :startPeriod AND :endPeriod')
                ->setParameter('startPeriod', $filters['period']['start'], Types::DATETIME_IMMUTABLE)
                ->setParameter('endPeriod', $filters['period']['end'], Types::DATETIME_IMMUTABLE);
        }
        unset($filters['period']);

        foreach ($filters as $key => $value) {
            switch (gettype($value)) {
                case 'array':
                    $qb->andWhere("e.$key IN (:{$key})")
                        ->setParameter($key, $value);
                    break;
                case 'NULL':
                    $qb->andWhere("e.$key IS NULL");
                    break;
                case 'boolean':
                    $qb->andWhere("e.$key is :$key")
                        ->setParameter($key, $value, Types::BOOLEAN);
                    break;
                default: $qb->andWhere("e.$key = :$key")
                    ->setParameter($key, $value);
            };
        }
        foreach ($order as $key => $value) {
            $qb->orderBy("e.$key", $value);
        }

        return $qb
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function save(Event $event): Event
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();

        return $event;
    }
}

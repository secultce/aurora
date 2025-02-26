<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\City;
use App\Entity\State;
use App\Repository\Interface\CityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class CityRepository extends AbstractRepository implements CityRepositoryInterface
{
    public function __construct(ManagerRegistry $manager)
    {
        parent::__construct($manager, City::class);
    }

    public function findByState(State|string $state): array
    {
        if ($state instanceof State) {
            return $this->findBy(
                ['state' => $state],
                ['name' => 'ASC']
            );
        }

        if (2 === strlen($state)) {
            return $this->getEntityManager()->createQueryBuilder()
                ->select('c')
                ->from(City::class, 'c')
                ->join('c.state', 's')
                ->where('s.acronym = :acronym')
                ->setParameter('acronym', strtoupper($state))
                ->orderBy('c.name', 'ASC')
                ->getQuery()
                ->getResult();
        }

        return [];
    }
}

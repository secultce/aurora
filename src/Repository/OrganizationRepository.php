<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Organization;
use App\Repository\Interface\OrganizationRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class OrganizationRepository extends AbstractRepository implements OrganizationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organization::class);
    }

    public function save(Organization $organization): Organization
    {
        $this->getEntityManager()->persist($organization);
        $this->getEntityManager()->flush();

        return $organization;
    }

    public function findOneById(string $id): ?Organization
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

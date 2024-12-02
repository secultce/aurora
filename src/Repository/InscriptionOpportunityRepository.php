<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\InscriptionOpportunity;
use App\Repository\Interface\InscriptionOpportunityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class InscriptionOpportunityRepository extends AbstractRepository implements InscriptionOpportunityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionOpportunity::class);
    }

    public function save(InscriptionOpportunity $inscriptionOpportunity): InscriptionOpportunity
    {
        $this->getEntityManager()->persist($inscriptionOpportunity);
        $this->getEntityManager()->flush();

        return $inscriptionOpportunity;
    }

    public function findInscriptionsByOpportunity($opportunityId, array $agents, int $limit)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $qb->select('io')
            ->from(InscriptionOpportunity::class, 'io')
            ->join('io.opportunity', 'o')
            ->where('io.opportunity = :opportunityId')
            ->andWhere('o.createdBy IN (:agents)')
            ->setParameter('opportunityId', $opportunityId)
            ->setParameter('agents', $agents)
            ->setMaxResults($limit)
            ->orderBy('io.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findOneInscriptionOpportunity(string $inscriptionId, string $opportunityId, array $agents)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $qb->select('io')
            ->from(InscriptionOpportunity::class, 'io')
            ->join('io.opportunity', 'o')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->andX(
                        'o.createdBy IN (:agents)',
                        'io.agent NOT IN (:agents)'
                    ),
                    $qb->expr()->andX(
                        'io.agent IN (:agents)',
                        'o.createdBy NOT IN (:agents)'
                    )
                )
            )
            ->andWhere('io.id = :inscriptionId')
            ->andWhere('o.id = :opportunityId')
            ->setParameter('inscriptionId', $inscriptionId)
            ->setParameter('opportunityId', $opportunityId)
            ->setParameter('agents', $agents)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

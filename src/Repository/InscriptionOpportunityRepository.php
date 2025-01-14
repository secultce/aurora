<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\InscriptionOpportunity;
use App\Entity\InscriptionPhase;
use App\Entity\Phase;
use App\Repository\Interface\InscriptionOpportunityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class InscriptionOpportunityRepository extends AbstractRepository implements InscriptionOpportunityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionOpportunity::class);
    }

    public function create(InscriptionOpportunity $inscriptionOpportunity, ?InscriptionPhase $inscriptionPhase = null): InscriptionOpportunity
    {
        if (null !== $inscriptionPhase) {
            $this->getEntityManager()->persist($inscriptionPhase);
        }

        return $this->save($inscriptionOpportunity);
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

    public function findRecentByUser(Uuid $userId, int $limit = 4): array
    {
        return $this->createQueryBuilder('io')
            ->join('io.agent', 'a')
            ->where('a.user = :user')
            ->setParameter('user', $userId)
            ->orderBy('io.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findUserInscriptionsWithDetails(Uuid $agentId): iterable
    {
        $qb = $this->createQueryBuilder('i');

        $subQuery = $this->getEntityManager()->createQueryBuilder()
            ->select('MAX(p2.startDate)')
            ->from(Phase::class, 'p2')
            ->where('p2.opportunity = o.id');

        return $qb->select('i', 'o', 'p')
            ->join('i.opportunity', 'o')
            ->join(Phase::class, 'p', 'WITH', 'p.opportunity = o.id AND p.startDate = ('.$subQuery->getDQL().')')
            ->where('i.agent = :agentId')
            ->setParameter('agentId', $agentId)
            ->getQuery()
            ->getResult();
    }
}

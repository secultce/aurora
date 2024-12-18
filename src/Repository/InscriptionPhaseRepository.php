<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\InscriptionPhase;
use App\Entity\Phase;
use App\Repository\Interface\InscriptionPhaseRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class InscriptionPhaseRepository extends AbstractRepository implements InscriptionPhaseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionPhase::class);
    }

    public function save(InscriptionPhase $inscriptionPhase): InscriptionPhase
    {
        $this->getEntityManager()->persist($inscriptionPhase);
        $this->getEntityManager()->flush();

        return $inscriptionPhase;
    }

    public function isAgentInscribedInPreviousPhases(Uuid $opportunity, Uuid $agent, Uuid $currentPhase): bool
    {
        $currentPhase = self::getEntityManager()->find(Phase::class, $currentPhase);

        $sequence = $currentPhase->getSequence();

        $qb = $this->createQueryBuilder('ip')
            ->select('COUNT(ip.id)')
            ->join('ip.phase', 'p')
            ->where('p.opportunity = :opportunity')
            ->andWhere('ip.agent = :agent')
            ->andWhere('p.sequence < :sequence')
            ->setParameter('opportunity', $opportunity->toRfc4122())
            ->setParameter('agent', $agent->toRfc4122())
            ->setParameter('sequence', $sequence);

        $count = (int) $qb->getQuery()->getSingleScalarResult();

        return $count === ($sequence - 1);
    }
}

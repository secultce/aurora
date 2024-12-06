<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\InscriptionPhase;
use App\Repository\Interface\InscriptionPhaseRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

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
}

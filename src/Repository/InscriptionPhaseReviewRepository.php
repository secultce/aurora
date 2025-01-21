<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\InscriptionPhaseReview;
use App\Repository\Interface\InscriptionPhaseReviewRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class InscriptionPhaseReviewRepository extends AbstractRepository implements InscriptionPhaseReviewRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionPhaseReview::class);
    }

    public function save(InscriptionPhaseReview $inscriptionPhaseReview): InscriptionPhaseReview
    {
        $this->getEntityManager()->persist($inscriptionPhaseReview);
        $this->getEntityManager()->flush();

        return $inscriptionPhaseReview;
    }
}

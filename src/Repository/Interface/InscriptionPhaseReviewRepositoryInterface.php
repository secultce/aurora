<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\InscriptionPhaseReview;

interface InscriptionPhaseReviewRepositoryInterface
{
    public function save(InscriptionPhaseReview $inscriptionPhaseReview): InscriptionPhaseReview;
}

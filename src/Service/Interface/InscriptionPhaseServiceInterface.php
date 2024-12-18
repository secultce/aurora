<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\InscriptionPhase;
use Symfony\Component\Uid\Uuid;

interface InscriptionPhaseServiceInterface
{
    public function create(Uuid $opportunity, Uuid $phase, array $inscriptionPhase): InscriptionPhase;
}

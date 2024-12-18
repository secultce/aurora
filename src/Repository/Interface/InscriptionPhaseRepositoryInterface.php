<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\InscriptionPhase;
use Symfony\Component\Uid\Uuid;

interface InscriptionPhaseRepositoryInterface
{
    public function save(InscriptionPhase $inscriptionPhase): InscriptionPhase;

    public function isAgentInscribedInPreviousPhases(Uuid $opportunity, Uuid $agent, Uuid $currentPhase): bool;
}

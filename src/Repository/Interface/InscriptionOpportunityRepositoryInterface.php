<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\InscriptionOpportunity;
use App\Entity\InscriptionPhase;

interface InscriptionOpportunityRepositoryInterface
{
    public function create(InscriptionOpportunity $inscriptionOpportunity, ?InscriptionPhase $inscriptionPhase = null): InscriptionOpportunity;

    public function findOneInscriptionOpportunity(string $inscriptionId, string $opportunityId, array $agents);

    public function findInscriptionsByOpportunity(string $opportunityId, array $agents, int $limit);
}

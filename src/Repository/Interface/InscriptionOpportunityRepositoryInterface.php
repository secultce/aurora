<?php

declare(strict_types=1);

namespace App\Repository\Interface;

interface InscriptionOpportunityRepositoryInterface
{
    public function findOneInscriptionOpportunity(string $inscriptionId, string $opportunityId, array $agents);

    public function findInscriptionsByOpportunity(string $opportunityId, array $agents, int $limit);
}

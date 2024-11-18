<?php

declare(strict_types=1);

namespace App\Service\Interface;

interface DetailsOpportunityServiceInterface
{
    public function findDetailsById(string $id): ?array;
}

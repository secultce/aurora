<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\State;

interface CityRepositoryInterface
{
    public function findByState(State|string $state): array;
}

<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Phase;
use Symfony\Component\Uid\Uuid;

interface PhaseServiceInterface
{
    public function create(Uuid $opportunity, array $phase): Phase;
}

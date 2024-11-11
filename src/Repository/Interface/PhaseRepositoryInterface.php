<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\Phase;

interface PhaseRepositoryInterface
{
    public function save(Phase $phase): Phase;
}

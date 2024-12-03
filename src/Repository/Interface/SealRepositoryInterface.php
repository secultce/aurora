<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\Seal;

interface SealRepositoryInterface
{
    public function save(Seal $seal): Seal;
}

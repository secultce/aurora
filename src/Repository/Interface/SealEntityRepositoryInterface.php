<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\SealEntity;

interface SealEntityRepositoryInterface
{
    public function save(SealEntity $sealEntity): SealEntity;
}

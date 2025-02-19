<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\SpaceType;

interface SpaceTypeRepositoryInterface
{
    public function save(SpaceType $spaceType): SpaceType;
}

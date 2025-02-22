<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\SpaceType;
use Symfony\Component\Uid\Uuid;

interface SpaceTypeServiceInterface
{
    public function create(array $spaceType): SpaceType;

    public function get(Uuid $id): SpaceType;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;

    public function update(Uuid $id, array $spaceType): SpaceType;
}

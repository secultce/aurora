<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Space;
use Symfony\Component\Uid\Uuid;

interface SpaceServiceInterface
{
    public function create(array $space): Space;

    public function get(Uuid $id): Space;

    public function findOneBy(array $params): Space;

    public function findBy(array $params = []): array;

    public function list(int $limit = 50): array;

    public function count(): int;

    public function remove(Uuid $id): void;

    public function update(Uuid $identifier, array $space): Space;
}

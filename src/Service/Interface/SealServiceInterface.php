<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Seal;
use Symfony\Component\Uid\Uuid;

interface SealServiceInterface
{
    public function get(Uuid $id): Seal;

    public function findOneBy(array $params): ?Seal;

    public function findBy(array $params = []): array;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;
}

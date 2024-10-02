<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Initiative;
use Symfony\Component\Uid\Uuid;

interface InitiativeServiceInterface
{
    public function get(Uuid $id): Initiative;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;

    public function create(array $initiative): Initiative;

    public function update(Uuid $id, array $initiative): Initiative;
}

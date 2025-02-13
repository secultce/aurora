<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\EventActivity;
use Symfony\Component\Uid\Uuid;

interface EventActivityServiceInterface
{
    public function create(Uuid $event, array $eventActivity): EventActivity;

    public function findBy(array $params = []): array;

    public function findOneBy(array $params): ?EventActivity;

    public function get(Uuid $event, Uuid $id): EventActivity;

    public function list(Uuid $event, int $limit = 50): array;

    public function remove(Uuid $event, Uuid $id): void;

    public function update(Uuid $event, Uuid $id, array $eventActivity): EventActivity;
}

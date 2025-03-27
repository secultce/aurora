<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\Event;

interface EventRepositoryInterface
{
    public function findByFilters(array $filters, array $order = [], int $limit = 50): array;

    public function save(Event $event): Event;
}

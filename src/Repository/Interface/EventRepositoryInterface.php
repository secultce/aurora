<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\Event;

interface EventRepositoryInterface
{
    public function save(Event $event): Event;

    public function findByAgent(string $agentId): array;
}

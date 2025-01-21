<?php

declare(strict_types=1);

namespace App\Document;

use App\Service\Interface\UserServiceInterface;
use Symfony\Component\Uid\Uuid;

abstract class AbstractDocument
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {
    }

    public function assignAuthor($event): void
    {
        $userId = Uuid::fromString($event->getUserId());
        $event->author = $this->userService->get($userId);
    }

    public function getEvents(array $events): array
    {
        return array_map(function ($event) {
            $this->assignAuthor($event);

            return $event;
        }, $events);
    }
}

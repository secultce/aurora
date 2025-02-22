<?php

declare(strict_types=1);

namespace App\Document;

use App\Entity\User;
use App\Service\Interface\UserServiceInterface;
use Symfony\Component\Uid\Uuid;

abstract class AbstractDocument
{
    public ?User $author = null;

    public function __construct(
        private readonly ?UserServiceInterface $userService = null,
    ) {
    }

    private function assignAuthor(User $user): void
    {
        $this->author = $user;
    }

    public function getEvents(array $events): array
    {
        return array_map(
            function (AbstractDocument $event) {
                if (null !== $event->getUserId()) {
                    $user = $this->userService->get(Uuid::fromString($event->getUserId()));
                    $event->assignAuthor($user);
                }

                return $event->toArray();
            },
            $events
        );
    }

    public function toArray(): array
    {
        return [
            'author' => $this->author?->toArray() ?? null,
            'id' => $this->getId(),
            'userId' => $this->getUserId(),
            'resourceId' => $this->getResourceId(),
            'title' => $this->getTitle(),
            'priority' => $this->getPriority(),
            'datetime' => $this->getDatetime(),
            'device' => $this->getDevice(),
            'platform' => $this->getPlatform(),
            'from' => $this->getFrom(),
            'to' => $this->getTo(),
        ];
    }
}

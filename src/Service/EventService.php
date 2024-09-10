<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Event;
use App\Exception\Event\EventResourceNotFoundException;
use App\Repository\Interface\EventRepositoryInterface;
use App\Service\Interface\EventServiceInterface;
use Symfony\Component\Uid\Uuid;

readonly class EventService implements EventServiceInterface
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
    ) {
    }

    public function get(Uuid $id): Event
    {
        $event = $this->eventRepository->find($id);

        if (null === $event) {
            throw new EventResourceNotFoundException();
        }

        return $event;
    }

    public function list(): array
    {
        return $this->eventRepository->findAll();
    }
}

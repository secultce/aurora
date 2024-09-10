<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Event;
use App\Exception\Event\EventResourceNotFoundException;
use App\Repository\Interface\EventRepositoryInterface;
use App\Service\Interface\EventServiceInterface;
use DateTime;
use Symfony\Component\Uid\Uuid;

readonly class EventService implements EventServiceInterface
{
    private const DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private EventRepositoryInterface $repository,
    ) {
    }

    public function get(Uuid $id): Event
    {
        $event = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $event) {
            throw new EventResourceNotFoundException();
        }

        return $event;
    }

    public function list(): array
    {
        return $this->repository->findBy(self::DEFAULT_FILTERS);
    }

    public function remove(Uuid $id): void
    {
        $event = $this->get($id);
        $event->setDeletedAt(new DateTime());

        $this->repository->save($event);
    }
}

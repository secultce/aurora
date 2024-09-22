<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\EventDto;
use App\Entity\Event;
use App\Exception\Event\EventResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\EventRepositoryInterface;
use App\Service\Interface\EventServiceInterface;
use DateTime;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class EventService implements EventServiceInterface
{
    private const DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private EventRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function create(array $event): Event
    {
        $eventDto = $this->serializer->denormalize($event, EventDto::class);

        $violations = $this->validator->validate($eventDto, groups: EventDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $eventObj = $this->serializer->denormalize($event, Event::class);

        return $this->repository->save($eventObj);
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
        return $this->repository->findBy(
            self::DEFAULT_FILTERS,
            ['createdAt' => 'DESC']
        );
    }

    public function remove(Uuid $id): void
    {
        $event = $this->get($id);
        $event->setDeletedAt(new DateTime());

        $this->repository->save($event);
    }
}

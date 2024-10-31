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
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class EventService extends AbstractEntityService implements EventServiceInterface
{
    public function __construct(
        private EventRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($security);
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
            ...$this->getDefaultParams(),
        ]);

        if (null === $event) {
            throw new EventResourceNotFoundException();
        }

        return $event;
    }

    public function findOneBy(array $params): ?Event
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function list(int $limit = 50): array
    {
        return $this->repository->findBy(
            $this->getDefaultParams(),
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function count(): int
    {
        return $this->repository->count(
            $this->getDefaultParams()
        );
    }

    public function remove(Uuid $id): void
    {
        $event = $this->repository->findOneBy(
            [...['id' => $id], ...$this->getUserParams()]
        );

        if (null === $event) {
            throw new EventResourceNotFoundException();
        }

        $event->setDeletedAt(new DateTime());

        $this->repository->save($event);
    }

    public function update(Uuid $identifier, array $event): Event
    {
        $eventFromDB = $this->get($identifier);

        $eventDto = $this->serializer->denormalize($event, EventDto::class);

        $violations = $this->validator->validate($eventDto, groups: EventDto::UPDATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $eventObj = $this->serializer->denormalize($event, Event::class, context: [
            'object_to_populate' => $eventFromDB,
        ]);

        $eventObj->setUpdatedAt(new DateTime());

        return $this->repository->save($eventObj);
    }
}

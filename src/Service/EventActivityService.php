<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\EventActivityDto;
use App\Entity\EventActivity;
use App\Exception\EventActivity\EventActivityResourceNotFoundException;
use App\Repository\Interface\EventActivityRepositoryInterface;
use App\Repository\Interface\EventRepositoryInterface;
use App\Service\Interface\EventActivityServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class EventActivityService extends AbstractEntityService implements EventActivityServiceInterface
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private EventActivityRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security, $this->serializer, $this->validator);
    }

    public function create(Uuid $event, array $eventActivity): EventActivity
    {
        $eventActivity = $this->validateInput($eventActivity, EventActivityDto::class, EventActivityDto::CREATE);

        $eventActivityObj = $this->serializer->denormalize($eventActivity, EventActivity::class);

        $eventObj = $this->eventRepository->findOneBy(['id' => $event]);

        $eventActivityObj->setEvent($eventObj);

        return $this->repository->save($eventActivityObj);
    }

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['startDate' => 'DESC'],
            $limit
        );
    }

    public function findOneBy(array $params): ?EventActivity
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function get(Uuid $event, Uuid $id): EventActivity
    {
        $event = $this->repository->findOneBy([
            'id' => $id,
            'event' => $event,
        ]);

        if (null === $event) {
            throw new EventActivityResourceNotFoundException();
        }

        return $event;
    }

    public function list(Uuid $event, int $limit = 50, array $params = []): array
    {
        $params['event'] = $event;

        return $this->repository->findBy(
            [...$params],
            ['startDate' => 'DESC'],
            $limit
        );
    }

    public function remove(Uuid $event, Uuid $id): void
    {
        $eventActivity = $this->repository->findOneBy(['id' => $id, 'event' => $event]);

        if (null === $eventActivity) {
            throw new EventActivityResourceNotFoundException();
        }

        $this->repository->remove($eventActivity);
    }

    public function update(Uuid $event, Uuid $id, array $eventActivity): EventActivity
    {
        $eventActivityFromDB = $this->get($event, $id);

        $eventActivityDto = $this->validateInput($eventActivity, EventActivityDto::class, EventActivityDto::UPDATE);

        $eventActivityObj = $this->serializer->denormalize($eventActivityDto, EventActivity::class, context: [
            'object_to_populate' => $eventActivityFromDB,
        ]);

        $eventActivityObj->setEvent($eventActivityFromDB->getEvent());

        return $this->repository->save($eventActivityObj);
    }
}

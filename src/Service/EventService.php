<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\EventDto;
use App\Entity\Agent;
use App\Entity\Event;
use App\Exception\Event\EventResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\EventRepositoryInterface;
use App\Service\Interface\EventServiceInterface;
use App\Service\Interface\FileServiceInterface;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class EventService extends AbstractEntityService implements EventServiceInterface
{
    public function __construct(
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
        private EventRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security);
    }

    public function count(?Agent $createdBy = null): int
    {
        $criteria = $this->getDefaultParams();

        if ($createdBy) {
            $criteria['createdBy'] = $createdBy;
        }

        return $this->repository->count($criteria);
    }

    public function create(array $event): Event
    {
        $event = self::validateInput($event, EventDto::CREATE);

        $eventObj = $this->serializer->denormalize($event, Event::class);

        $eventObj->setCreatedBy(
            $this->getAgentsFromLoggedUser()[0]
        );

        return $this->repository->save($eventObj);
    }

    private function denormalizeDto(array $data): EventDto
    {
        return $this->serializer->denormalize($data, EventDto::class, context: [
            AbstractNormalizer::CALLBACKS => [
                'image' => function () use ($data): ?File {
                    if (false === isset($data['image'])) {
                        return null;
                    }

                    return $this->fileService->uploadImage($this->parameterBag->get('app.dir.event.profile'), $data['image']);
                },
            ],
        ]);
    }

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function findOneBy(array $params): ?Event
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
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

    public function list(int $limit = 50, array $params = []): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getDefaultParams()],
            ['createdAt' => 'DESC'],
            $limit
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

        $eventDto = self::validateInput($event, EventDto::UPDATE);

        $eventObj = $this->serializer->denormalize($eventDto, Event::class, context: [
            'object_to_populate' => $eventFromDB,
        ]);

        $eventObj->setUpdatedAt(new DateTime());

        return $this->repository->save($eventObj);
    }

    public function updateImage(Uuid $id, UploadedFile $uploadedFile): Event
    {
        $event = $this->get($id);

        $eventDto = new EventDto();
        $eventDto->image = $uploadedFile;

        $violations = $this->validator->validate($eventDto, groups: [EventDto::UPDATE]);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        if ($event->getImage()) {
            $this->fileService->deleteFileByUrl($event->getImage());
        }

        $uploadedImage = $this->fileService->uploadImage(
            $this->parameterBag->get('app.dir.event.profile'),
            $uploadedFile
        );

        $event->setImage($this->fileService->urlOfImage($uploadedImage->getFilename()));

        $event->setUpdatedAt(new DateTime());

        $this->repository->save($event);

        return $event;
    }

    private function validateInput(array $event, string $group): array
    {
        $eventDto = self::denormalizeDto($event);

        $violations = $this->validator->validate($eventDto, groups: $group);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        return $event;
    }
}

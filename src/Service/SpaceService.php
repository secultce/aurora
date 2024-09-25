<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\SpaceDto;
use App\Entity\Space;
use App\Exception\Space\SpaceResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\SpaceRepositoryInterface;
use App\Service\Interface\SpaceServiceInterface;
use DateTime;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class SpaceService implements SpaceServiceInterface
{
    private const DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private SpaceRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function create(array $space): Space
    {
        $spaceDto = $this->serializer->denormalize($space, SpaceDto::class);

        $violations = $this->validator->validate($spaceDto, groups: SpaceDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $spaceObj = $this->serializer->denormalize($space, Space::class);

        return $this->repository->save($spaceObj);
    }

    public function get(Uuid $id): Space
    {
        $space = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $space) {
            throw new SpaceResourceNotFoundException();
        }

        return $space;
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
        $space = $this->get($id);
        $space->setDeletedAt(new DateTime());

        $this->repository->save($space);
    }

    public function update(Uuid $identifier, array $space): Space
    {
        $spaceFromDB = $this->get($identifier);

        $spaceDto = $this->serializer->denormalize($space, SpaceDto::class);

        $violations = $this->validator->validate($spaceDto, groups: SpaceDto::UPDATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $spaceObj = $this->serializer->denormalize($space, Space::class, context: [
            'object_to_populate' => $spaceFromDB,
        ]);

        $spaceObj->setUpdatedAt(new DateTime());

        return $this->repository->save($spaceObj);
    }
}

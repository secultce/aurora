<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ActivityAreaDto;
use App\Entity\ActivityArea;
use App\Exception\ActivityArea\ActivityAreaResourceNotFoundException;
use App\Repository\Interface\ActivityAreaRepositoryInterface;
use App\Service\Interface\ActivityAreaServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ActivityAreaService extends AbstractEntityService implements ActivityAreaServiceInterface
{
    public function __construct(
        private ActivityAreaRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct(
            $this->security,
            $this->serializer,
            $this->validator
        );
    }

    public function create(array $activityArea): ActivityArea
    {
        $activityArea = $this->validateInput($activityArea, ActivityAreaDto::class, ActivityAreaDto::CREATE);

        $activityAreaObj = $this->serializer->denormalize($activityArea, ActivityArea::class);

        return $this->repository->save($activityAreaObj);
    }

    public function get(Uuid $id): ActivityArea
    {
        $activityArea = $this->findOneBy(['id' => $id]);

        if (null === $activityArea) {
            throw new ActivityAreaResourceNotFoundException();
        }

        return $activityArea;
    }

    public function list(int $limit = 50, array $params = []): array
    {
        return $this->repository->findBy(
            $params,
            ['name' => 'ASC'],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $activityArea = $this->findOneBy(['id' => $id]);

        if (null === $activityArea) {
            throw new ActivityAreaResourceNotFoundException();
        }

        $this->repository->remove($activityArea);
    }

    private function findOneBy(array $array): ?ActivityArea
    {
        return $this->repository->findOneBy($array);
    }

    public function update(Uuid $id, array $activityArea): ActivityArea
    {
        $activityAreaFromDB = $this->get($id);

        $activityAreaDto = $this->validateInput($activityArea, ActivityAreaDto::class, ActivityAreaDto::UPDATE);

        $activityAreaObj = $this->serializer->denormalize(
            $activityAreaDto,
            ActivityArea::class,
            context: ['object_to_populate' => $activityAreaFromDB]
        );

        return $this->repository->save($activityAreaObj);
    }
}

<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\SpaceDto;
use App\Entity\Agent;
use App\Entity\Space;
use App\Exception\Space\SpaceResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\SpaceRepositoryInterface;
use App\Service\Interface\FileServiceInterface;
use App\Service\Interface\SpaceServiceInterface;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class SpaceService extends AbstractEntityService implements SpaceServiceInterface
{
    public function __construct(
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
        private SpaceRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($security);
    }

    public function count(?Agent $createdBy = null): int
    {
        $criteria = $this->getDefaultParams();

        if ($createdBy) {
            $criteria['createdBy'] = $createdBy;
        }

        return $this->repository->count($criteria);
    }

    public function create(array $space): Space
    {
        $space = self::validateInput($space, SpaceDto::CREATE);

        $spaceObj = $this->serializer->denormalize($space, Space::class);

        return $this->repository->save($spaceObj);
    }

    private function denormalizeDto(array $data): SpaceDto
    {
        return $this->serializer->denormalize($data, SpaceDto::class, context: [
            AbstractNormalizer::CALLBACKS => [
                'image' => function () use ($data): ?File {
                    if (false === isset($data['image'])) {
                        return null;
                    }

                    return $this->fileService->uploadImage($this->parameterBag->get('app.dir.space.profile'), $data['image']);
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

    public function findOneBy(array $params): Space
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function get(Uuid $id): Space
    {
        $space = $this->repository->findOneBy([
            ...['id' => $id],
            ...$this->getDefaultParams(),
        ]);

        if (null === $space) {
            throw new SpaceResourceNotFoundException();
        }

        return $space;
    }

    public function list(int $limit = 50, array $params = [], string $order = 'DESC'): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getDefaultParams()],
            ['createdAt' => $order],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $space = $this->repository->findOneBy(
            [...['id' => $id], ...$this->getUserParams()]
        );

        if (null === $space) {
            throw new SpaceResourceNotFoundException();
        }

        $space->setDeletedAt(new DateTime());

        $this->repository->save($space);
    }

    public function update(Uuid $identifier, array $space): Space
    {
        $spaceFromDB = $this->get($identifier);

        $spaceDto = self::validateInput($space, SpaceDto::UPDATE);

        $spaceObj = $this->serializer->denormalize($spaceDto, Space::class, context: [
            'object_to_populate' => $spaceFromDB,
        ]);

        $spaceObj->setUpdatedAt(new DateTime());

        return $this->repository->save($spaceObj);
    }

    public function updateImage(Uuid $id, UploadedFile $uploadedFile): Space
    {
        $space = $this->get($id);

        $spaceDto = new SpaceDto();
        $spaceDto->image = $uploadedFile;

        $violations = $this->validator->validate($spaceDto, groups: [SpaceDto::UPDATE]);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        if ($space->getImage()) {
            $this->fileService->deleteFileByUrl($space->getImage());
        }

        $uploadedImage = $this->fileService->uploadImage(
            $this->parameterBag->get('app.dir.space.profile'),
            $uploadedFile
        );

        $space->setImage($this->fileService->urlOfImage($uploadedImage->getFilename()));

        $space->setUpdatedAt(new DateTime());

        $this->repository->save($space);

        return $space;
    }

    private function validateInput(array $space, string $group): array
    {
        $spaceDto = self::denormalizeDto($space);

        $violations = $this->validator->validate($spaceDto, groups: $group);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        return $space;
    }
}

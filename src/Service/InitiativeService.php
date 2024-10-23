<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\InitiativeDto;
use App\Entity\Initiative;
use App\Exception\Initiative\InitiativeResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\InitiativeRepositoryInterface;
use App\Service\Interface\FileServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class InitiativeService implements InitiativeServiceInterface
{
    private const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private InitiativeRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function get(Uuid $id): Initiative
    {
        $initiative = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $initiative) {
            throw new InitiativeResourceNotFoundException();
        }

        return $initiative;
    }

    public function list(int $limit = 50): array
    {
        return $this->repository->findBy(
            self::DEFAULT_FILTERS,
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $initiative = $this->get($id);
        $initiative->setDeletedAt(new DateTime());

        $this->repository->save($initiative);
    }

    public function create(array $initiative): Initiative
    {
        $initiative = self::validateInput($initiative, InitiativeDto::CREATE);

        $initiativeObj = $this->serializer->denormalize($initiative, Initiative::class);

        return $this->repository->save($initiativeObj);
    }

    public function update(Uuid $id, array $initiative): Initiative
    {
        $initiativeFromDB = $this->get($id);

        $initiativeDto = self::validateInput($initiative, InitiativeDto::UPDATE);

        $initiativeObj = $this->serializer->denormalize($initiativeDto, Initiative::class, context: [
            'object_to_populate' => $initiativeFromDB,
        ]);

        $initiativeObj->setUpdatedAt(new DateTime());

        return $this->repository->save($initiativeObj);
    }

    private function validateInput(array $initiative, string $group): array
    {
        $initiativeDto = self::denormalizeDto($initiative);

        $violations = $this->validator->validate($initiativeDto, groups: $group);

        if ($violations->count() > 0) {
            if ($initiativeDto->image instanceof File) {
                $this->fileService->deleteFile($initiativeDto->image->getRealPath());
            }

            throw new ValidatorException(violations: $violations);
        }

        if ($initiativeDto->image instanceof File) {
            $initiative = array_merge($initiative, ['image' => $initiativeDto->image]);
        }

        return $initiative;
    }

    private function denormalizeDto(array $data): InitiativeDto
    {
        return $this->serializer->denormalize($data, InitiativeDto::class, context: [
            AbstractNormalizer::CALLBACKS => [
                'image' => function () use ($data): ?File {
                    if (false === isset($data['image'])) {
                        return null;
                    }

                    return $this->fileService->uploadImage($this->parameterBag->get('app.dir.initiative.profile'), $data['image']);
                },
            ],
        ]);
    }
}

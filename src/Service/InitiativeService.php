<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\InitiativeDto;
use App\Entity\Initiative;
use App\Exception\Initiative\InitiativeResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\InitiativeRepositoryInterface;
use App\Service\Interface\InitiativeServiceInterface;
use DateTime;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class InitiativeService extends AbstractEntityService implements InitiativeServiceInterface
{
    private const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private InitiativeRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
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

    public function list(array $filters = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            array_merge($filters, self::DEFAULT_FILTERS),
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
        $initiative = $this->get($id);
        $initiative->setDeletedAt(new DateTime());

        $this->repository->save($initiative);
    }

    public function create(array $initiative): Initiative
    {
        $initiativeDto = $this->serializer->denormalize($initiative, InitiativeDto::class);

        $violations = $this->validator->validate($initiativeDto, groups: InitiativeDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $initiativeObj = $this->serializer->denormalize($initiative, Initiative::class);

        return $this->repository->save($initiativeObj);
    }

    public function update(Uuid $id, array $initiative): Initiative
    {
        $initiativeFromDB = $this->get($id);

        $initiativeDto = $this->serializer->denormalize($initiative, InitiativeDto::class);

        $violations = $this->validator->validate($initiativeDto, groups: InitiativeDto::UPDATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $initiativeObj = $this->serializer->denormalize($initiative, Initiative::class, context: [
            'object_to_populate' => $initiativeFromDB,
        ]);

        $initiativeObj->setUpdatedAt(new DateTime());

        return $this->repository->save($initiativeObj);
    }
}

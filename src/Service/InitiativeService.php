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

readonly class InitiativeService implements InitiativeServiceInterface
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

    public function list(): array
    {
        return $this->repository->findBy(
            self::DEFAULT_FILTERS,
            ['createdAt' => 'DESC']
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
}

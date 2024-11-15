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
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class InitiativeService extends AbstractEntityService implements InitiativeServiceInterface
{
    public function __construct(
        private Security $security,
        private InitiativeRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security);
    }

    public function get(Uuid $id): Initiative
    {
        $initiative = $this->repository->findOneBy([
            ...['id' => $id],
            ...$this->getDefaultParams(),
        ]);

        if (null === $initiative) {
            throw new InitiativeResourceNotFoundException();
        }

        return $initiative;
    }

    public function findOneBy(array $params): Initiative
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
        $initiative = $this->get($id);
        $initiative->setDeletedAt(new DateTime());

        $this->repository->save($initiative);
    }

    public function create(array $initiative): Initiative|ConstraintViolationList
    {
        $initiativeDto = $this->serializer->denormalize($initiative, InitiativeDto::class);

        $violations = $this->validator->validate($initiativeDto, groups: InitiativeDto::CREATE);

        if ($violations->count() > 0) {
            return $violations;
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

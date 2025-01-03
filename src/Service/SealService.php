<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\SealDto;
use App\Entity\Seal;
use App\Exception\Seal\SealResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\SealRepositoryInterface;
use App\Service\Interface\SealServiceInterface;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class SealService extends AbstractEntityService implements SealServiceInterface
{
    public function __construct(
        private SealRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security);
    }

    public function create(array $seal): Seal
    {
        $seal = self::validateInput($seal, SealDto::CREATE);

        $sealObj = $this->serializer->denormalize($seal, Seal::class);

        return $this->repository->save($sealObj);
    }

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function findOneBy(array $params): ?Seal
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function get(Uuid $id): Seal
    {
        $seal = $this->repository->findOneBy([
            ...['id' => $id],
            ...$this->getDefaultParams(),
        ]);

        if (null === $seal) {
            throw new SealResourceNotFoundException();
        }

        return $seal;
    }

    public function list(int $limit = 50): array
    {
        return $this->repository->findBy(
            $this->getUserParams(),
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $seal = $this->findOneBy(
            [...['id' => $id], ...$this->getUserParams()]
        );

        if (null === $seal) {
            throw new SealResourceNotFoundException();
        }

        $seal->setDeletedAt(new DateTime());

        $this->repository->save($seal);
    }

    public function update(Uuid $identifier, array $seal): Seal
    {
        $sealFromDB = $this->get($identifier);

        $sealDto = self::validateInput($seal, SealDto::UPDATE);

        $sealObj = $this->serializer->denormalize($sealDto, Seal::class, context: [
            'object_to_populate' => $sealFromDB,
        ]);

        $sealObj->setUpdatedAt(new DateTime());

        return $this->repository->save($sealObj);
    }

    private function validateInput(array $seal, string $group): array
    {
        $sealDto = $this->serializer->denormalize($seal, SealDto::class);

        $violations = $this->validator->validate($sealDto, groups: $group);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        return $seal;
    }
}

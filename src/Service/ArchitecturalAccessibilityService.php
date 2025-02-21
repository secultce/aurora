<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ArchitecturalAccessibilityDto;
use App\Entity\ArchitecturalAccessibility;
use App\Exception\ArchitecturalAccessibility\ArchitecturalAccessibilityResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\ArchitecturalAccessibilityRepositoryInterface;
use App\Service\Interface\ArchitecturalAccessibilityServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ArchitecturalAccessibilityService extends AbstractEntityService implements ArchitecturalAccessibilityServiceInterface
{
    public function __construct(
        private ArchitecturalAccessibilityRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security);
    }

    public function create(array $architecturalAccessibility): ArchitecturalAccessibility
    {
        $architecturalAccessibility = self::validateInput($architecturalAccessibility, ArchitecturalAccessibilityDto::CREATE);

        $architecturalAccessibilityObj = $this->serializer->denormalize($architecturalAccessibility, ArchitecturalAccessibility::class);

        return $this->repository->save($architecturalAccessibilityObj);
    }

    public function getOne(Uuid $id): ArchitecturalAccessibility
    {
        $architecturalAccessibility = $this->findOneBy(['id' => $id]);

        if (null === $architecturalAccessibility) {
            throw new ArchitecturalAccessibilityResourceNotFoundException();
        }

        return $architecturalAccessibility;
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
        $architecturalAccessibility = $this->findOneBy(['id' => $id]);

        if (null === $architecturalAccessibility) {
            throw new ArchitecturalAccessibilityResourceNotFoundException();
        }

        $this->repository->remove($architecturalAccessibility);
    }

    private function findOneBy(array $array): ?ArchitecturalAccessibility
    {
        return $this->repository->findOneBy($array);
    }

    public function update(Uuid $id, array $architecturalAccessibility): ArchitecturalAccessibility
    {
        $architecturalAccessibilityFromDB = $this->getOne($id);

        $architecturalAccessibilityDto = self::validateInput($architecturalAccessibility, ArchitecturalAccessibilityDto::UPDATE);

        $architecturalAccessibilityObj = $this->serializer->denormalize($architecturalAccessibilityDto, ArchitecturalAccessibility::class, context: [
            'object_to_populate' => $architecturalAccessibilityFromDB,
        ]);

        return $this->repository->save($architecturalAccessibilityObj);
    }

    private function validateInput(array $architecturalAccessibility, string $group): array
    {
        $architecturalAccessibilityDto = $this->serializer->denormalize($architecturalAccessibility, ArchitecturalAccessibilityDto::class);

        $violations = $this->validator->validate($architecturalAccessibilityDto, groups: $group);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        return $architecturalAccessibility;
    }
}

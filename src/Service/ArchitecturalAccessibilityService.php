<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ArchitecturalAccessibilityDto;
use App\Entity\ArchitecturalAccessibility;
use App\Exception\ArchitecturalAccessibility\ArchitecturalAccessibilityResourceNotFoundException;
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
        parent::__construct($this->security, $this->serializer, $this->validator);
    }

    public function create(array $architecturalAccessibility): ArchitecturalAccessibility
    {
        $architecturalAccessibility = $this->validateInput($architecturalAccessibility, ArchitecturalAccessibilityDto::class, ArchitecturalAccessibilityDto::CREATE);

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

        $architecturalAccessibilityDto = $this->validateInput($architecturalAccessibility, ArchitecturalAccessibilityDto::class, ArchitecturalAccessibilityDto::UPDATE);

        $architecturalAccessibilityObj = $this->serializer->denormalize($architecturalAccessibilityDto, ArchitecturalAccessibility::class, context: [
            'object_to_populate' => $architecturalAccessibilityFromDB,
        ]);

        return $this->repository->save($architecturalAccessibilityObj);
    }
}

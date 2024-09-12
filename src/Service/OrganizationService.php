<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\OrganizationDto;
use App\Entity\Organization;
use App\Exception\Organization\OrganizationResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\OrganizationRepositoryInterface;
use App\Service\Interface\OrganizationServiceInterface;
use DateTime;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class OrganizationService implements OrganizationServiceInterface
{
    private const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private OrganizationRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function create(array $organization): Organization
    {
        $organizationDto = $this->serializer->denormalize($organization, OrganizationDto::class);

        $violations = $this->validator->validate($organizationDto);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $organizationObj = $this->serializer->denormalize($organization, Organization::class);

        return $this->repository->save($organizationObj);
    }

    public function get(Uuid $id): Organization
    {
        $organization = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $organization) {
            throw new OrganizationResourceNotFoundException();
        }

        return $organization;
    }

    public function list(): array
    {
        return $this->repository->findBy(self::DEFAULT_FILTERS);
    }

    public function remove(Uuid $id): void
    {
        $organization = $this->get($id);
        $organization->setDeletedAt(new DateTime());

        $this->repository->save($organization);
    }
}

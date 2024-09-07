<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Organization;
use App\Exception\Organization\OrganizationResourceNotFoundException;
use App\Repository\Interface\OrganizationRepositoryInterface;
use App\Service\Interface\OrganizationServiceInterface;
use Symfony\Component\Uid\Uuid;

readonly class OrganizationService implements OrganizationServiceInterface
{
    private const DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private OrganizationRepositoryInterface $repository
    ) {
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
    }
}

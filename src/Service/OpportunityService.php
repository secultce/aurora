<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Opportunity;
use App\Exception\Opportunity\OpportunityResourceNotFoundException;
use App\Repository\Interface\OpportunityRepositoryInterface;
use App\Service\Interface\OpportunityServiceInterface;
use Symfony\Component\Uid\Uuid;

readonly class OpportunityService implements OpportunityServiceInterface
{
    private const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private OpportunityRepositoryInterface $repository
    ) {
    }

    public function get(Uuid $id): Opportunity
    {
        $organization = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $organization) {
            throw new OpportunityResourceNotFoundException();
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

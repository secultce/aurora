<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\OpportunityDto;
use App\Entity\Opportunity;
use App\Exception\Opportunity\OpportunityResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\OpportunityRepositoryInterface;
use App\Service\Interface\OpportunityServiceInterface;
use DateTime;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class OpportunityService implements OpportunityServiceInterface
{
    private const array DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private OpportunityRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function create(array $opportunity): Opportunity
    {
        $opportunityDto = $this->serializer->denormalize($opportunity, OpportunityDto::class);

        $violations = $this->validator->validate($opportunityDto, groups: OpportunityDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $opportunityObj = $this->serializer->denormalize($opportunity, Opportunity::class);

        return $this->repository->save($opportunityObj);
    }

    public function get(Uuid $id): Opportunity
    {
        $opportunity = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $opportunity) {
            throw new OpportunityResourceNotFoundException();
        }

        return $opportunity;
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
        $opportunity = $this->get($id);
        $opportunity->setDeletedAt(new DateTime());

        $this->repository->save($opportunity);
    }

    public function update(Uuid $identifier, array $opportunity): Opportunity
    {
        $opportunityFromDB = $this->get($identifier);

        $opportunityDto = $this->serializer->denormalize($opportunity, OpportunityDto::class);

        $violations = $this->validator->validate($opportunityDto, groups: OpportunityDto::UPDATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $opportunityObj = $this->serializer->denormalize($opportunity, Opportunity::class, context: [
            'object_to_populate' => $opportunityFromDB,
        ]);

        $opportunityObj->setUpdatedAt(new DateTime());

        return $this->repository->save($opportunityObj);
    }
}

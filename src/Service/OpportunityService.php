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
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class OpportunityService extends AbstractEntityService implements OpportunityServiceInterface
{
    public function __construct(
        private Security $security,
        private OpportunityRepositoryInterface $repository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($security);
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
            ...$this->getDefaultParams(),
        ]);

        if (null === $opportunity) {
            throw new OpportunityResourceNotFoundException();
        }

        return $opportunity;
    }

    public function findOneBy(array $params): Opportunity
    {
        return $this->repository->findOneBy(
            [...$params, ...$this->getDefaultParams()]
        );
    }

    public function list(int $limit = 50, array $params = []): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getDefaultParams()],
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

    public function findBy(array $params = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            [...$params, ...$this->getUserParams()],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $opportunity = $this->repository->findOneBy(
            [...['id' => $id], ...$this->getUserParams()]
        );

        if (null === $opportunity) {
            throw new OpportunityResourceNotFoundException();
        }

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

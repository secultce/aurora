<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\OpportunityDto;
use App\Entity\Opportunity;
use App\Exception\Opportunity\OpportunityResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\OpportunityRepositoryInterface;
use App\Service\Interface\FileServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
        private FileServiceInterface $fileService,
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function create(array $opportunity): Opportunity
    {
        $opportunity = self::validateInput($opportunity, OpportunityDto::CREATE);

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

    public function list(array $filters = [], int $limit = 50): array
    {
        return $this->repository->findBy(
            array_merge($filters, self::DEFAULT_FILTERS),
            ['createdAt' => 'DESC'],
            $limit
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

        $opportunityDto = self::validateInput($opportunity, OpportunityDto::UPDATE);

        $opportunityObj = $this->serializer->denormalize($opportunityDto, Opportunity::class, context: [
            'object_to_populate' => $opportunityFromDB,
        ]);

        $opportunityObj->setUpdatedAt(new DateTime());

        return $this->repository->save($opportunityObj);
    }

    private function validateInput(array $opportunity, string $group): array
    {
        $opportunityDto = self::denormalizeDto($opportunity);

        $violations = $this->validator->validate($opportunityDto, groups: $group);

        if ($violations->count() > 0) {
            if ($opportunityDto->image instanceof File) {
                $this->fileService->deleteFile($opportunityDto->image->getRealPath());
            }

            throw new ValidatorException(violations: $violations);
        }

        if ($opportunityDto->image instanceof File) {
            $opportunity = array_merge($opportunity, ['image' => $opportunityDto->image]);
        }

        return $opportunity;
    }

    private function denormalizeDto(array $data): OpportunityDto
    {
        return $this->serializer->denormalize($data, OpportunityDto::class, context: [
            AbstractNormalizer::CALLBACKS => [
                'image' => function () use ($data): ?File {
                    if (false === isset($data['image'])) {
                        return null;
                    }

                    return $this->fileService->uploadImage($this->parameterBag->get('app.dir.opportunity.profile'), $data['image']);
                },
            ],
        ]);
    }
}

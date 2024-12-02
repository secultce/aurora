<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\InscriptionOpportunityDto;
use App\Entity\InscriptionOpportunity;
use App\Exception\InscriptionOpportunity\AlreadyInscriptionOpportunityException;
use App\Exception\InscriptionOpportunity\InscriptionOpportunityResourceNotFoundException;
use App\Exception\UnauthorizedException;
use App\Exception\ValidatorException;
use App\Repository\Interface\InscriptionOpportunityRepositoryInterface;
use App\Service\Interface\InscriptionOpportunityServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class InscriptionOpportunityService extends AbstractEntityService implements InscriptionOpportunityServiceInterface
{
    public function __construct(
        private Security $security,
        private InscriptionOpportunityRepositoryInterface $repository,
        private OpportunityServiceInterface $opportunityService,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($security);
    }

    public function create(Uuid $opportunity, array $inscriptionOpportunity): InscriptionOpportunity
    {
        $inscriptionOpportunity['opportunity'] = $opportunity->toRfc4122();

        $inscriptionOpportunityDto = $this->serializer->denormalize($inscriptionOpportunity, InscriptionOpportunityDto::class);

        $violations = $this->validator->validate($inscriptionOpportunityDto, groups: InscriptionOpportunityDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $this->opportunityShouldNotBelongsToAgent($opportunity, $inscriptionOpportunity['agent']);

        $inscriptionOpportunityObj = $this->serializer->denormalize($inscriptionOpportunity, InscriptionOpportunity::class);

        try {
            return $this->repository->save($inscriptionOpportunityObj);
        } catch (UniqueConstraintViolationException) {
            throw new AlreadyInscriptionOpportunityException();
        }
    }

    public function get(Uuid $opportunity, Uuid $id): InscriptionOpportunity
    {
        $inscriptionOpportunity = $this->repository->findOneInscriptionOpportunity($id->toRfc4122(), $opportunity->toRfc4122(), $this->security->getUser()->getAgents()->getValues());

        if (null === $inscriptionOpportunity) {
            throw new InscriptionOpportunityResourceNotFoundException();
        }

        return $inscriptionOpportunity;
    }

    public function list(Uuid $opportunity, int $limit = 50): array
    {
        return $this->repository->findInscriptionsByOpportunity(
            $opportunity->toRfc4122(),
            $this->security->getUser()->getAgents()->getValues(),
            $limit
        );
    }

    public function remove(Uuid $opportunity, Uuid $id): void
    {
        $inscriptionOpportunity = $this->repository->findOneBy(
            [...['id' => $id, 'opportunity' => $opportunity], ...$this->getUserParams()]
        );

        if (null === $inscriptionOpportunity) {
            throw new InscriptionOpportunityResourceNotFoundException();
        }

        $inscriptionOpportunity->setDeletedAt(new DateTime());

        $this->repository->save($inscriptionOpportunity);
    }

    public function update(Uuid $opportunity, Uuid $identifier, array $inscriptionOpportunity): InscriptionOpportunity
    {
        $inscriptionOpportunity['opportunity'] = $opportunity->toRfc4122();

        $inscriptionOpportunityFromDB = $this->repository->findOneBy(
            [...['id' => $identifier, 'opportunity' => $opportunity], ...$this->getUserParams()]
        );

        if (null === $inscriptionOpportunityFromDB) {
            throw new InscriptionOpportunityResourceNotFoundException();
        }

        $inscriptionOpportunityDto = $this->serializer->denormalize($inscriptionOpportunity, InscriptionOpportunityDto::class);

        $violations = $this->validator->validate($inscriptionOpportunityDto, groups: InscriptionOpportunityDto::UPDATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $agent = $inscriptionOpportunity['agent'] ?? $inscriptionOpportunityFromDB->getAgent()->getId()->toRfc4122();

        $this->opportunityShouldNotBelongsToAgent($opportunity, $agent);

        $inscriptionOpportunityObj = $this->serializer->denormalize($inscriptionOpportunity, InscriptionOpportunity::class, context: [
            'object_to_populate' => $inscriptionOpportunityFromDB,
        ]);

        $inscriptionOpportunityObj->setUpdatedAt(new DateTime());

        return $this->repository->save($inscriptionOpportunityObj);
    }

    private function opportunityShouldNotBelongsToAgent(Uuid $opportunity, string $agent): void
    {
        $opportunity = $this->opportunityService->get($opportunity);

        if ($opportunity->getCreatedBy()->getId()->toRfc4122() === $agent) {
            throw new UnauthorizedException();
        }
    }

    public function getUserParams(): array
    {
        $params = parent::DEFAULT_FILTERS;

        if (null !== $this->security->getUser()) {
            $agents = $this->security->getUser()->getAgents()->getValues();

            $params['agent'] = $agents;
        }

        return $params;
    }
}

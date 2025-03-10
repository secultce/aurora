<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\InscriptionPhaseDto;
use App\Entity\InscriptionPhase;
use App\Exception\InscriptionPhase\AgentNotInscribedInPreviousPhasesException;
use App\Exception\InscriptionPhase\AlreadyInscriptionPhaseException;
use App\Exception\Phase\PhaseResourceNotFoundException;
use App\Exception\UnauthorizedException;
use App\Repository\Interface\InscriptionPhaseRepositoryInterface;
use App\Service\Interface\InscriptionPhaseServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use App\Service\Interface\PhaseServiceInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class InscriptionPhaseService extends AbstractEntityService implements InscriptionPhaseServiceInterface
{
    public function __construct(
        private Security $security,
        private InscriptionPhaseRepositoryInterface $repository,
        private OpportunityServiceInterface $opportunityService,
        private PhaseServiceInterface $phaseService,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security, $this->serializer, $this->validator);
    }

    public function create(Uuid $opportunity, Uuid $phase, array $inscriptionPhase): InscriptionPhase
    {
        $inscriptionPhase['phase'] = $phase->toRfc4122();

        $inscriptionPhase = $this->validateInput($inscriptionPhase, InscriptionPhaseDto::class, InscriptionPhaseDto::CREATE);

        $this->opportunityShouldNotBelongsToAgent($opportunity, Uuid::fromString($inscriptionPhase['agent']));
        $this->phaseShouldBelongsToOpportunity($opportunity, $phase);

        if (false === $this->repository->isAgentInscribedInPreviousPhases($opportunity, Uuid::fromString($inscriptionPhase['agent']), $phase)) {
            throw new AgentNotInscribedInPreviousPhasesException();
        }

        $inscriptionPhaseObj = $this->serializer->denormalize($inscriptionPhase, InscriptionPhase::class);

        try {
            return $this->repository->save($inscriptionPhaseObj);
        } catch (UniqueConstraintViolationException) {
            throw new AlreadyInscriptionPhaseException();
        }
    }

    private function opportunityShouldNotBelongsToAgent(Uuid $opportunity, Uuid $agent): void
    {
        $opportunity = $this->opportunityService->get($opportunity);

        if ($opportunity->getCreatedBy()->getId()->toRfc4122() === $agent->toRfc4122()) {
            throw new UnauthorizedException();
        }
    }

    private function phaseShouldBelongsToOpportunity(Uuid $opportunity, Uuid $phase): void
    {
        try {
            $this->phaseService->get($opportunity, $phase);
        } catch (PhaseResourceNotFoundException) {
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

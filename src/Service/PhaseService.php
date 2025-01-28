<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\PhaseDto;
use App\Entity\Phase;
use App\Exception\Phase\PhaseResourceNotFoundException;
use App\Exception\ValidatorException;
use App\Repository\Interface\PhaseRepositoryInterface;
use App\Service\Interface\PhaseServiceInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class PhaseService extends AbstractEntityService implements PhaseServiceInterface
{
    public function __construct(
        private Security $security,
        private PhaseRepositoryInterface $repository,
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($security);
    }

    public function create(Uuid $opportunity, array $phase): Phase
    {
        $phase['opportunity'] = $opportunity->toRfc4122();

        $phaseDto = $this->serializer->denormalize($phase, PhaseDto::class);

        $violations = $this->validator->validate($phaseDto, groups: PhaseDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $phaseObj = $this->serializer->denormalize($phase, Phase::class);

        $phaseObj->setCreatedBy(
            $this->getAgentsFromLoggedUser()[0]
        );
        $phaseObj->setSequence($this->findSequenceNumber(Phase::class, $opportunity));
        $phaseObj->setCriteria([]);

        return $this->repository->save($phaseObj);
    }

    public function get(Uuid $opportunity, Uuid $id): Phase
    {
        $phase = $this->repository->findOneBy(['id' => $id, 'opportunity' => $opportunity]);

        if (null === $phase) {
            throw new PhaseResourceNotFoundException();
        }

        return $phase;
    }

    public function list(Uuid $opportunity, int $limit = 50): array
    {
        return $this->repository->findBy(
            ['opportunity' => $opportunity],
            ['sequence' => 'ASC'],
            $limit
        );
    }

    public function remove(Uuid $opportunity, Uuid $id): void
    {
        $phase = $this->repository->findOneBy(
            [...['id' => $id, 'opportunity' => $opportunity], ...$this->getUserParams()]
        );

        if (null === $phase) {
            throw new PhaseResourceNotFoundException();
        }

        $phase->setDeletedAt(new DateTime());

        $this->repository->save($phase);
    }

    public function update(Uuid $opportunity, Uuid $identifier, array $phase): Phase
    {
        $phase['opportunity'] = $opportunity->toRfc4122();

        $phaseFromDB = $this->get($opportunity, $identifier);

        $phaseDto = $this->serializer->denormalize($phase, PhaseDto::class);

        $violations = $this->validator->validate($phaseDto, groups: PhaseDto::UPDATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $phaseObj = $this->serializer->denormalize($phase, Phase::class, context: [
            'object_to_populate' => $phaseFromDB,
        ]);

        $phaseObj->setUpdatedAt(new DateTime());

        return $this->repository->save($phaseObj);
    }

    private function findSequenceNumber(string $entityName, Uuid $opportunity): int
    {
        return $this->entityManager->createQueryBuilder()
            ->select('(coalesce(max(entity.sequence), 0) + 1)')
            ->from($entityName, 'entity')
            ->where('entity.opportunity = :opportunity')
            ->setParameter('opportunity', $opportunity)
            ->getQuery()
            ->getSingleScalarResult();
    }
}

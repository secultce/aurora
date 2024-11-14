<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\PhaseDto;
use App\Entity\Phase;
use App\Exception\ValidatorException;
use App\Repository\Interface\PhaseRepositoryInterface;
use App\Service\Interface\PhaseServiceInterface;
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
        $phase['opportunity'] = $opportunity;

        $phaseDto = $this->serializer->denormalize($phase, PhaseDto::class);

        $violations = $this->validator->validate($phaseDto, groups: PhaseDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $phaseObj = $this->serializer->denormalize($phase, Phase::class);

        $phaseObj->setSequence($this->findSequenceNumber(Phase::class, $opportunity));

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

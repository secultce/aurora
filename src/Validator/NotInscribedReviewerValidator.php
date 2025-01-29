<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\InscriptionPhase;
use App\Validator\Constraints\NotInscribedReviewer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class NotInscribedReviewerValidator extends ConstraintValidator
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof NotInscribedReviewer) {
            throw new UnexpectedTypeException($constraint, NotInscribedReviewer::class);
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        $opportunity = $this->context->getRoot()->opportunity;

        $inscribedAgents = $this->entityManager->getRepository(InscriptionPhase::class)
            ->createQueryBuilder('ip')
            ->select('a.id')
            ->join('ip.agent', 'a')
            ->join('ip.phase', 'p')
            ->where('p.opportunity = :opportunity')
            ->setParameter('opportunity', $opportunity)
            ->getQuery()
            ->getResult();

        $inscribedAgentIds = array_map(fn ($inscription) => $inscription['id']->toRfc4122(), $inscribedAgents);

        foreach ($value as $reviewer) {
            if (in_array($reviewer, $inscribedAgentIds, true)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ reviewer }}', $reviewer)
                    ->addViolation();
            }
        }
    }
}

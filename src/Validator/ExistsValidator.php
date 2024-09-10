<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\Exists;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class ExistsValidator extends ConstraintValidator
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (false === $constraint instanceof Exists) {
            throw new UnexpectedTypeException($constraint, Exists::class);
        }

        if (null === $value || '' === $value || [] === $value) {
            return;
        }

        if (false === $constraint->entity || false === class_exists($constraint->entity)) {
            throw new UnexpectedValueException($constraint->entity, 'class');
        }

        $ids = \is_array($value) ? $value : [$value];

        $repository = $this->entityManager->getRepository($constraint->entity);

        $queryBuilder = $repository->createQueryBuilder('e')
            ->select('e.id')
            ->where('e.id IN (:ids)')
            ->setParameter('ids', $ids);

        if (true === property_exists($constraint->entity, 'deletedAt')) {
            $queryBuilder->andWhere('e.deletedAt is null');
        }

        $results = $queryBuilder->getQuery()->getScalarResult();
        $foundIdentifiers = array_column($results, 'id');

        foreach ($ids as $position => $id) {
            if (true === \in_array($id, $foundIdentifiers)) {
                continue;
            }

            if (true === \is_string($value)) {
                $this->context->buildViolation($constraint->message)->addViolation();

                continue;
            }

            $this->context->buildViolation($constraint->message)
                ->atPath(sprintf('[%d]', $position))
                ->addViolation();
        }
    }
}

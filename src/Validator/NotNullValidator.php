<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class NotNullValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (false === $constraint instanceof NotNull) {
            throw new UnexpectedTypeException($constraint, NotNull::class);
        }

        $object = (array) $this->context->getObject();
        $property = $this->context->getPropertyPath();

        if (true === \array_key_exists($property, $object) && null === $object[$property]) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}

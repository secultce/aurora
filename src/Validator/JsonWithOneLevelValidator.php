<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\JsonWithOneLevel;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class JsonWithOneLevelValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof JsonWithOneLevel) {
            throw new UnexpectedTypeException($constraint, JsonWithOneLevel::class);
        }

        if (null === $value) {
            return;
        }

        if (false === is_array($value)) {
            throw new UnexpectedValueException($value, 'json object');
        }

        foreach ($value as $val) {
            if (true === is_array($val)) {
                $this->context->buildViolation($constraint->message)->addViolation();

                return;
            }
        }
    }
}

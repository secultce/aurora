<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraints\Json;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class JsonValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Json) {
            throw new UnexpectedTypeException($constraint, Json::class);
        }

        if (null === $value) {
            return;
        }

        if (false === is_array($value)) {
            throw new UnexpectedValueException($value, 'json object');
        }
    }
}

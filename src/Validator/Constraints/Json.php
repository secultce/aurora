<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\JsonValidator;
use Symfony\Component\Validator\Constraint;

final class Json extends Constraint
{
    public function validatedBy(): string
    {
        return JsonValidator::class;
    }
}

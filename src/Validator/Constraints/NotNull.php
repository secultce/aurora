<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\NotNullValidator;
use Symfony\Component\Validator\Constraint;

final class NotNull extends Constraint
{
    public string $message = 'This value should not be null.';

    public function validatedBy(): string
    {
        return NotNullValidator::class;
    }
}

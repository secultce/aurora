<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\JsonWithOneLevelValidator;
use Symfony\Component\Validator\Constraint;

final class JsonWithOneLevel extends Constraint
{
    public string $message = 'This value should be a valid json object with only one level of depth.';

    public function validatedBy(): string
    {
        return JsonWithOneLevelValidator::class;
    }
}

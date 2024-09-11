<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\ExistsValidator;
use Symfony\Component\Validator\Constraint;

final class Exists extends Constraint
{
    public string $message;

    public string $entity;

    public function __construct(string $entity, ?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        $this->entity = $entity;
        $this->message = $message ?? 'This id does not exist.';

        parent::__construct($options, $groups, $payload);
    }

    public function validatedBy(): string
    {
        return ExistsValidator::class;
    }
}

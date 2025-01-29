<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Validator\NotInscribedReviewerValidator;
use Symfony\Component\Validator\Constraint;

final class NotInscribedReviewer extends Constraint
{
    public string $message;

    public function __construct(?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        $this->message = $message ?? 'The agent {{ reviewer }} is registered on the opportunity and cannot be a reviewer.';

        parent::__construct($options, $groups, $payload);
    }

    public function validatedBy(): string
    {
        return NotInscribedReviewerValidator::class;
    }
}

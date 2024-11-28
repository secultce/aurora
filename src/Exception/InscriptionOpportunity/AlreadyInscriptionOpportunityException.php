<?php

declare(strict_types=1);

namespace App\Exception\InscriptionOpportunity;

use RuntimeException;
use Throwable;

class AlreadyInscriptionOpportunityException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        $message = 'The agent has already signed up for this opportunity.';

        parent::__construct($message, 0, $previous);
    }
}

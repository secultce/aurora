<?php

declare(strict_types=1);

namespace App\Exception\InscriptionPhase;

use RuntimeException;
use Throwable;

class AlreadyInscriptionPhaseException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        $message = 'The agent has already signed up for this phase.';

        parent::__construct($message, 0, $previous);
    }
}

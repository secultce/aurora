<?php

declare(strict_types=1);

namespace App\Exception\InscriptionPhase;

use RuntimeException;
use Throwable;

class AgentNotInscribedInPreviousPhasesException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        $message = 'The agent was not inscribed in previous phases.';

        parent::__construct($message, 0, $previous);
    }
}

<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

class UnauthorizedException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        $message = 'The requested was unauthorized.';

        parent::__construct($message, 0, $previous);
    }
}

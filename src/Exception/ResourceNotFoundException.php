<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

class ResourceNotFoundException extends RuntimeException
{
    protected const RESOURCE = '';

    public function __construct(?Throwable $previous = null)
    {
        $message = 'The requested resource was not found.';

        if ('' !== static::RESOURCE) {
            $message = sprintf('The requested %s was not found.', static::RESOURCE);
        }

        parent::__construct($message, 0, $previous);
    }
}

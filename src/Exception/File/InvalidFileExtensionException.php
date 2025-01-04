<?php

declare(strict_types=1);

namespace App\Exception\File;

use RuntimeException;
use Throwable;

class InvalidFileExtensionException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        $message = 'The file extension is invalid.';

        parent::__construct($message, 0, $previous);
    }
}

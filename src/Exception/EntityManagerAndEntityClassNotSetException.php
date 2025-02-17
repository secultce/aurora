<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

class EntityManagerAndEntityClassNotSetException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        $message = 'For use this method can be pass EntityManager and Entity ClassName in the constructor from this service.';

        parent::__construct($message, 0, $previous);
    }
}

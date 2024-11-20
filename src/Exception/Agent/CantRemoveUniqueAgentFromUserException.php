<?php

declare(strict_types=1);

namespace App\Exception\Agent;

use LogicException;
use Throwable;

class CantRemoveUniqueAgentFromUserException extends LogicException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        $message = 'Cannot remove unique agent from user.';
        parent::__construct($message, $code, $previous);
    }
}

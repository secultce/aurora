<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;

final class ErrorGeneralResponse extends ErrorResponse
{
    public function __construct(string $message, ?int $httpCode = null, ?array $details = [])
    {
        parent::__construct($message, $httpCode ?? Response::HTTP_BAD_REQUEST, $details);
    }
}

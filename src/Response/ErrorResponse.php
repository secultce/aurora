<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ErrorResponse extends JsonResponse
{
    public function __construct(string $message, int $httpCode, array $details = [])
    {
        $response = [
            'error_message' => $message,
        ];

        if (false === empty($details)) {
            $response['error_details'] = $details;
        }

        parent::__construct($response, $httpCode);
    }
}

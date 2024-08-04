<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class ExampleApiController
{
    public function getList(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'hello world',
        ]);
    }
}
<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Interface\AddressServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExampleApiController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function getList(): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->translator->trans('hello world'),
        ]);
    }
}

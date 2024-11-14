<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Interface\PhaseServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class PhaseApiController extends AbstractApiController
{
    public function __construct(
        private readonly PhaseServiceInterface $service,
    ) {
    }

    public function create(Uuid $opportunity, Request $request): JsonResponse
    {
        $opportunity = $this->service->create($opportunity, $request->toArray());

        return $this->json($opportunity, status: Response::HTTP_CREATED, context: ['groups' => ['phase.get', 'phase.get.item']]);
    }
}

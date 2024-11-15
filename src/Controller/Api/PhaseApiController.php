<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\PhaseServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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

    public function get(Uuid $opportunity, Uuid $id): JsonResponse
    {
        $phase = $this->service->get($opportunity, $id);

        return $this->json($phase, context: ['groups' => ['phase.get', 'phase.get.item']]);
    }

    public function list(Uuid $opportunity): JsonResponse
    {
        return $this->json($this->service->list($opportunity), context: [
            'groups' => 'phase.get',
            AbstractNormalizer::CALLBACKS => [
                'parent' => [EntityIdNormalizerHelper::class, 'normalizeEntityId'],
            ],
        ]);
    }

    public function update(Uuid $opportunity, Uuid $id, Request $request): JsonResponse
    {
        $phase = $this->service->update($opportunity, $id, $request->toArray());

        return $this->json($phase, Response::HTTP_OK, context: ['groups' => ['phase.get', 'phase.get.item']]);
    }

    public function remove(Uuid $opportunity, Uuid $id): JsonResponse
    {
        $this->service->remove($opportunity, $id);

        return $this->json(data: [], status: Response::HTTP_NO_CONTENT);
    }
}

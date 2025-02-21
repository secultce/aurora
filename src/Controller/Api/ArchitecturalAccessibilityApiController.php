<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\ArchitecturalAccessibilityServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class ArchitecturalAccessibilityApiController extends AbstractApiController
{
    public function __construct(
        private readonly ArchitecturalAccessibilityServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $architecturalAccessibility = $this->service->create($request->toArray());

        return $this->json($architecturalAccessibility, Response::HTTP_CREATED, context: ['groups' => 'architectural-accessibility.get']);
    }

    public function get(?Uuid $id): JsonResponse
    {
        $architecturalAccessibility = $this->service->getOne($id);

        return $this->json($architecturalAccessibility, context: ['groups' => 'architectural-accessibility.get']);
    }

    public function list(): JsonResponse
    {
        return $this->json($this->service->list(), context: [
            'groups' => 'architectural-accessibility.get',
            AbstractNormalizer::CALLBACKS => [
                'parent' => [EntityIdNormalizerHelper::class, 'normalizeEntityId'],
            ],
        ]);
    }

    public function remove(?Uuid $id): JsonResponse
    {
        $this->service->remove($id);

        return $this->json(data: [], status: Response::HTTP_NO_CONTENT);
    }

    public function update(?Uuid $id, Request $request): JsonResponse
    {
        $architecturalAccessibility = $this->service->update($id, $request->toArray());

        return $this->json($architecturalAccessibility, Response::HTTP_OK, context: ['groups' => 'architectural-accessibility.get']);
    }
}

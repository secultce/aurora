<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\ActivityAreaServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class ActivityAreaApiController extends AbstractApiController
{
    public function __construct(
        private readonly ActivityAreaServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $activityArea = $this->service->create($request->toArray());

        return $this->json($activityArea, Response::HTTP_CREATED, context: ['groups' => ['activity-area.get', 'activity-area.get.item']]);
    }

    public function get(?Uuid $id): JsonResponse
    {
        $activityArea = $this->service->get($id);

        return $this->json($activityArea, context: ['groups' => ['activity-area.get', 'activity-area.get.item']]);
    }

    public function list(): JsonResponse
    {
        return $this->json($this->service->list(), context: [
            'groups' => 'activity-area.get',
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
        $activityArea = $this->service->update($id, $request->toArray());

        return $this->json($activityArea, Response::HTTP_OK, context: ['groups' => ['activity-area.get', 'activity-area.get.item']]);
    }
}

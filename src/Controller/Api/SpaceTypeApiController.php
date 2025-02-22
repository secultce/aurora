<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\SpaceTypeServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

final class SpaceTypeApiController extends AbstractApiController
{
    public function __construct(
        private readonly SpaceTypeServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $spaceType = $this->service->create($request->toArray());

        return $this->json($spaceType, Response::HTTP_CREATED, context: ['groups' => ['space.get', 'space.get.item']]);
    }

    public function get(?Uuid $id): JsonResponse
    {
        $spaceType = $this->service->get($id);

        return $this->json($spaceType, context: ['groups' => ['space.get', 'space.get.item']]);
    }

    public function list(): JsonResponse
    {
        return $this->json($this->service->list(), context: [
            'groups' => 'space.get',
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
        $spaceType = $this->service->update($id, $request->toArray());

        return $this->json($spaceType, Response::HTTP_OK, context: ['groups' => ['space.get', 'space.get.item']]);
    }
}

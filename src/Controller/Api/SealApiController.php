<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\SealServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class SealApiController extends AbstractApiController
{
    public function __construct(
        private readonly SealServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $seal = $this->service->create($request->toArray());

        return $this->json($seal, status: Response::HTTP_CREATED, context: ['groups' => ['seal.get', 'seal.get.item']]);
    }

    public function get(?Uuid $id): JsonResponse
    {
        $seal = $this->service->get($id);

        return $this->json($seal, context: ['groups' => ['seal.get', 'seal.get.item']]);
    }

    public function list(): JsonResponse
    {
        return $this->json($this->service->list(), context: [
            'groups' => 'seal.get',
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
        $seal = $this->service->update($id, $request->toArray());

        return $this->json($seal, Response::HTTP_OK, context: ['groups' => ['seal.get', 'seal.get.item']]);
    }
}

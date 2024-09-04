<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class SpaceApiController extends AbstractApiController
{
    public function __construct(
        private readonly SpaceServiceInterface $service,
    ) {
    }

    public function get(?Uuid $id): JsonResponse
    {
        $space = $this->service->get($id);

        return $this->json($space, context: ['groups' => 'space.get']);
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
}

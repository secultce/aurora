<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\InitiativeServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class InitiativeApiController extends AbstractApiController
{
    public function __construct(
        private readonly InitiativeServiceInterface $service,
    ) {
    }

    public function get(?Uuid $id): JsonResponse
    {
        $initiative = $this->service->get($id);

        return $this->json($initiative, context: ['groups' => 'initiative.get']);
    }

    public function list(): JsonResponse
    {
        return $this->json($this->service->list(), context: [
            'groups' => 'initiative.get',
            AbstractNormalizer::CALLBACKS => [
                'parent' => [EntityIdNormalizerHelper::class, 'normalizeEntityId'],
            ],
        ]);
    }
}

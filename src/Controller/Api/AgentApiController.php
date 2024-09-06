<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\AgentServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class AgentApiController extends AbstractApiController
{
    public function __construct(
        private readonly AgentServiceInterface $service,
    ) {
    }

    public function get(Uuid $id): JsonResponse
    {
        $agent = $this->service->get($id);

        return $this->json($agent, context: ['groups' => 'agent.get']);
    }

    public function list(): JsonResponse
    {
        return $this->json($this->service->list(), context: [
            'groups' => 'agent.get',
            AbstractNormalizer::CALLBACKS => [
                'parent' => [EntityIdNormalizerHelper::class, 'normalizeEntityId'],
            ],
        ]);
    }
}

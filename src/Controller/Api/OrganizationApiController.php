<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\OrganizationServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class OrganizationApiController extends AbstractApiController
{
    public function __construct(
        private readonly OrganizationServiceInterface $service,
    ) {
    }

    public function get(?Uuid $id): JsonResponse
    {
        $organization = $this->service->get($id);

        return $this->json($organization, context: ['groups' => 'organization.get']);
    }

    public function list(): JsonResponse
    {
        return $this->json($this->service->list(), context: [
            'groups' => 'organization.get',
            AbstractNormalizer::CALLBACKS => [
                'parent' => [EntityIdNormalizerHelper::class, 'normalizeEntityId'],
            ],
        ]);
    }
}

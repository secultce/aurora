<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\OrganizationServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class OrganizationApiController extends AbstractApiController
{
    public function __construct(
        private readonly OrganizationServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $organization = $this->service->create($request->toArray());

        return $this->json($organization, status: Response::HTTP_CREATED, context: ['groups' => 'organization.get']);
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

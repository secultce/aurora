<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\OpportunityServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationList;

class OpportunityApiController extends AbstractApiController
{
    public function __construct(
        private readonly OpportunityServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $opportunity = $this->service->create($request->toArray());
        $statusCode = Response::HTTP_CREATED;

        if ($opportunity instanceof ConstraintViolationList) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($opportunity, status: $statusCode, context: ['groups' => ['opportunity.get', 'opportunity.get.item']]);
    }

    public function get(Uuid $id): JsonResponse
    {
        $opportunity = $this->service->get($id);

        return $this->json($opportunity, context: ['groups' => ['opportunity.get', 'opportunity.get.item']]);
    }

    public function list(): JsonResponse
    {
        return $this->json($this->service->list(), context: [
            'groups' => 'opportunity.get',
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
        $opportunity = $this->service->update($id, $request->toArray());

        return $this->json($opportunity, Response::HTTP_OK, context: ['groups' => ['opportunity.get', 'opportunity.get.item']]);
    }

    public function updateImage(Uuid $id, Request $request): JsonResponse
    {
        $image = $request->files->get('image');

        $opportunity = $this->service->updateImage($id, $image);

        return $this->json($opportunity, Response::HTTP_OK, context: ['groups' => ['opportunity.get', 'opportunity.get.item']]);
    }
}

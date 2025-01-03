<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Initiative;
use App\Helper\EntityIdNormalizerHelper;
use App\Service\Interface\InitiativeServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationList;

class InitiativeApiController extends AbstractApiController
{
    public function __construct(
        private readonly InitiativeServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $initiative = $this->service->create($request->toArray());
        $statusCode = Response::HTTP_CREATED;

        if ($initiative instanceof ConstraintViolationList) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($initiative, status: $statusCode, context: ['groups' => ['initiative.get', 'initiative.get.item']]);
    }

    public function get(?Uuid $id): JsonResponse
    {
        $initiative = $this->service->get($id);

        return $this->json($initiative, context: ['groups' => ['initiative.get', 'initiative.get.item']]);
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

    public function remove(?Uuid $id): JsonResponse
    {
        $this->service->remove($id);

        return $this->json(data: [], status: Response::HTTP_NO_CONTENT);
    }

    public function update(?Uuid $id, Request $request): JsonResponse
    {
        $initiative = $this->service->update($id, $request->toArray());

        return $this->json($initiative, Response::HTTP_OK, context: ['groups' => ['initiative.get', 'initiative.get.item']]);
    }

    public function updateImage(Uuid $id, Request $request): JsonResponse
    {
        $image = $request->files->get('image');

        $initiative = $this->service->updateImage($id, $image);

        return $this->json($initiative, context: ['groups' => ['initiative.get', 'initiative.get.item']]);
    }
}

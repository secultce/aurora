<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Enum\InscriptionOpportunityStatusEnum;
use App\Service\Interface\InscriptionOpportunityServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class InscriptionOpportunityApiController extends AbstractApiController
{
    private array $context;

    public function __construct(
        private readonly InscriptionOpportunityServiceInterface $service,
    ) {
        $this->context = [
            'groups' => ['inscription-opportunity.get'],
            AbstractNormalizer::CALLBACKS => [
                'status' => fn ($value) => InscriptionOpportunityStatusEnum::getName($value),
            ],
        ];
    }

    public function create(Uuid $opportunity, Request $request): JsonResponse
    {
        $inscriptionOpportunity = $this->service->create($opportunity, $request->toArray());

        return $this->json($inscriptionOpportunity, status: Response::HTTP_CREATED, context: $this->context);
    }

    public function get(Uuid $opportunity, Uuid $id): JsonResponse
    {
        $inscriptionOpportunity = $this->service->get($opportunity, $id);

        return $this->json($inscriptionOpportunity, context: $this->context);
    }

    public function remove(Uuid $opportunity, ?Uuid $id): JsonResponse
    {
        $this->service->remove($opportunity, $id);

        return $this->json(data: [], status: Response::HTTP_NO_CONTENT);
    }

    public function list(Uuid $opportunity): JsonResponse
    {
        return $this->json($this->service->list($opportunity), context: $this->context);
    }

    public function update(Uuid $opportunity, ?Uuid $id, Request $request): JsonResponse
    {
        $inscriptionOpportunity = $this->service->update($opportunity, $id, $request->toArray());

        return $this->json($inscriptionOpportunity, Response::HTTP_OK, context: $this->context);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Enum\InscriptionPhaseStatusEnum;
use App\Service\Interface\InscriptionPhaseServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Uid\Uuid;

class InscriptionPhaseApiController extends AbstractApiController
{
    private array $context;

    public function __construct(
        private readonly InscriptionPhaseServiceInterface $service,
    ) {
        $this->context = [
            'groups' => ['inscription-phase.get'],
            AbstractNormalizer::CALLBACKS => [
                'status' => fn ($value) => InscriptionPhaseStatusEnum::getName($value),
            ],
        ];
    }

    public function create(Uuid $opportunity, Uuid $phase, Request $request): JsonResponse
    {
        $inscriptionPhase = $this->service->create($opportunity, $phase, $request->toArray());

        return $this->json($inscriptionPhase, status: Response::HTTP_CREATED, context: $this->context);
    }
}

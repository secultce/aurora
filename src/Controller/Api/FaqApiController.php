<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Interface\FaqServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class FaqApiController extends AbstractApiController
{
    public function __construct(
        public readonly FaqServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $faq = $this->service->create($request->toArray());

        return $this->json(
            data: $faq,
            status: Response::HTTP_CREATED,
            context: ['groups' => ['faq.get', 'faq.get.item']]
        );
    }

    public function update(Uuid $id, Request $request): JsonResponse
    {
        $faq = $this->service->update($id, $request->toArray());

        return $this->json(
            data: $faq,
            status: Response::HTTP_OK,
            context: ['groups' => ['faq.get', 'faq.get.item']]
        );
    }
}

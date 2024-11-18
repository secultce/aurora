<?php

namespace App\Controller\Api;

use App\Service\Interface\AddressServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class AddressController extends AbstractApiController
{
    public function __construct(
        private readonly AddressServiceInterface $service,
    ) {
    }

    public function create(Request $request): JsonResponse
    {
        $address = $this->service->create($request->toArray());

        return $this->json($address, Response::HTTP_CREATED, context: ['groups' => ['address.get', 'address.get.item']]);
    }

    public function remove(?Uuid $id): JsonResponse
    {
        $this->service->remove($id);

        return $this->json(data: [], status: Response::HTTP_NO_CONTENT);
    }

    public function update(Uuid $id, Request $request): JsonResponse
    {
        $address = $this->service->update($id, $request->toArray());

        return $this->json($address, context: ['groups' => ['address.get', 'address.get.item']]);
    }
}

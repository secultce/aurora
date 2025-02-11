<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Interface\EventActivityServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class EventActivityApiController extends AbstractApiController
{
    public function __construct(
        public readonly EventActivityServiceInterface $service,
    ) {
    }

    public function get(Uuid $event, Uuid $id): JsonResponse
    {
        $event = $this->service->get($event, $id);

        return $this->json($event, context: ['groups' => ['event-activity.get']]);
    }

    public function list(Uuid $event): JsonResponse
    {
        return $this->json($this->service->list($event), context: ['groups' => 'event-activity.get']);
    }

    public function remove(Uuid $event, Uuid $id): JsonResponse
    {
        $this->service->remove($event, $id);

        return $this->json(data: [], status: Response::HTTP_NO_CONTENT);
    }
}

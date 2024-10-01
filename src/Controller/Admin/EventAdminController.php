<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\EventServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class EventAdminController extends AbstractAdminController
{
    public function __construct(
        public readonly EventServiceInterface $service,
    ) {
    }

    public function list(): Response
    {
        $entity = [
            'color' => '#8E46B4',
            'items' => [
                ['text' => 'event.dashboard.registered', 'icon' => 'description', 'quantity' => 12],
                ['text' => 'event.dashboard.realized', 'icon' => 'event_note', 'quantity' => 8],
                ['text' => 'event.dashboard.finished', 'icon' => 'event_available', 'quantity' => 6],
                ['text' => 'event.dashboard.seven.days.registered', 'icon' => 'today', 'quantity' => 3],
            ],
        ];

        return $this->render('event/list.html.twig', [
            'event' => $entity,
        ]);
    }
}

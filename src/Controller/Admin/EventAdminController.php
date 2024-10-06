<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\EventServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Response;

class EventAdminController extends AbstractAdminController
{
    public function __construct(
        public readonly EventServiceInterface $service,
    ) {
    }

    public function list(): Response
    {
        $events = $this->service->list();
        $totalEvents = count($events);

        $dashboard = [
            'color' => '#8E46B4',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalEvents, text: 'event.dashboard.registered'),
                new CardItem(icon: 'event_note', quantity: 10, text: 'event.dashboard.realized'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'event.dashboard.finished'),
                new CardItem(icon: 'today', quantity: 30, text: 'event.dashboard.seven.days.registered'),
            ],
        ];

        return $this->render('event/list.html.twig', [
            'dashboard' => $dashboard,
            'events' => $events,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Service\Interface\EventServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class EventWebController extends AbstractWebController
{
    public function __construct(
        public readonly EventServiceInterface $service
    ) {
    }

    public function list(Request $request): Response
    {
        $filters = $request->query->all();

        $filters = $this->getOrderParam($filters);

        $events = $this->service->list(params: $filters['filters'], order: $filters['order']);
        $totalEvents = count($events);

        $dashboard = [
            'color' => '#f5b932',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalEvents, text: 'view.event.quantity.total'),
                new CardItem(icon: 'event_note', quantity: 10, text: 'view.event.quantity.opened'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'view.event.quantity.finished'),
                new CardItem(icon: 'today', quantity: 30, text: 'view.event.quantity.last_days'),
            ],
        ];

        return $this->render('event/list.html.twig', [
            'dashboard' => $dashboard,
            'events' => $events,
            'totalEvents' => $totalEvents,
        ]);
    }

    public function show(Uuid $id): Response
    {
        $event = $this->service->get($id);

        return $this->render('event/show.html.twig', ['event' => $event]);
    }
}

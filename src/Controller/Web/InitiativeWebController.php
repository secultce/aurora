<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Service\Interface\InitiativeServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class InitiativeWebController extends AbstractWebController
{
    private InitiativeServiceInterface $initiativeService;

    public function __construct(InitiativeServiceInterface $initiativeService)
    {
        $this->initiativeService = $initiativeService;
    }

    public function list(Request $request): Response
    {
        $filters = $request->query->all();

        $filters = $this->getOrderParam($filters);

        $initiatives = $this->initiativeService->list(params: $filters['filters'], order: $filters['order']);
        $totalInitiatives = count($initiatives);

        $dashboard = [
            'color' => 'var(--navlink-initiative)',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalInitiatives, text: 'view.initiative.quantity.total'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'view.initiative.quantity.finished'),
                new CardItem(icon: 'event_note', quantity: 10, text: 'view.initiative.quantity.opened'),
                new CardItem(icon: 'today', quantity: 30, text: 'view.initiative.quantity.last_days'),
            ],
        ];

        return $this->render('initiative/list.html.twig', [
            'initiatives' => $initiatives,
            'dashboard' => $dashboard,
            'totalInitiatives' => $totalInitiatives,
        ]);
    }

    public function show(Uuid $id): Response
    {
        $initiative = $this->initiativeService->get($id);

        return $this->render('initiative/show.html.twig', ['initiative' => $initiative]);
    }
}

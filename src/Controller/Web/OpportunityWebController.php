<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Exception\ResourceNotFoundException;
use App\Service\Interface\OpportunityServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class OpportunityWebController extends AbstractWebController
{
    public function __construct(
        public readonly OpportunityServiceInterface $service
    ) {
    }

    public function list(Request $request): Response
    {
        $filters = $request->query->all();

        $filters = $this->getOrderParam($filters);

        $opportunities = $this->service->list(params: $filters['filters'], order: $filters['order']);
        $totalOpportunities = count($opportunities);

        $dashboard = [
            'color' => '#009874',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalOpportunities, text: 'view.opportunity.quantity.total'),
                new CardItem(icon: 'event_note', quantity: 10, text: 'view.opportunity.quantity.opened'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'view.opportunity.quantity.finished'),
                new CardItem(icon: 'today', quantity: 30, text: 'view.opportunity.quantity.last_days'),
            ],
        ];

        return $this->render('opportunity/list.html.twig', [
            'dashboard' => $dashboard,
            'opportunities' => $opportunities,
            'totalOpportunities' => $totalOpportunities,
        ]);
    }

    public function details(Uuid $id): Response
    {
        $opportunity = $this->service->get($id);

        if (!$opportunity) {
            throw new ResourceNotFoundException();
        }

        return $this->render('opportunity/details.html.twig', [
            'opportunity' => $opportunity,
        ]);
    }
}

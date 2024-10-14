<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Service\Interface\OpportunityServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Response;

class OpportunityWebController extends AbstractWebController
{
    public function __construct(
        public readonly OpportunityServiceInterface $service
    ) {
    }

    public function list(): Response
    {
        $opportunities = $this->service->list();
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
        ]);
    }
}

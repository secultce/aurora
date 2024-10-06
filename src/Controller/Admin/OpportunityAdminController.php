<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\OpportunityServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Response;

class OpportunityAdminController extends AbstractAdminController
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
            'color' => '#D14526',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalOpportunities, text: 'opened_registrations'),
                new CardItem(icon: 'event_note', quantity: 10, text: 'opportunity.registrations_closed'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'opportunity.future_registrations'),
                new CardItem(icon: 'today', quantity: 30, text: 'opportunity.official_notices'),
            ],
        ];

        return $this->render('opportunity/list.html.twig', [
            'dashboard' => $dashboard,
            'opportunities' => $opportunities,
        ]);
    }
}

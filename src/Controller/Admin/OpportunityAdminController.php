<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\OpportunityServiceInterface;
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

        $entity = [
            'color' => '#D14526',
            'items' => [
                ['text' => 'open_registrations', 'icon' => 'description', 'quantity' => 40],
                ['text' => 'opportunity.registrations_closed', 'icon' => 'event_note', 'quantity' => 20],
                ['text' => 'opportunity.future_registrations', 'icon' => 'event_available', 'quantity' => 6],
                ['text' => 'opportunity.official_notices', 'icon' => 'today', 'quantity' => 15],
            ],
        ];

        return $this->render('opportunity/list.html.twig', [
            'opportunity' => $entity,
            'opportunities' => $opportunities,
        ]);
    }
}

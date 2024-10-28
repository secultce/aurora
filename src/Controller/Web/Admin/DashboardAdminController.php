<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\EventServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class DashboardAdminController extends AbstractAdminController
{
    public function __construct(
        readonly private AgentServiceInterface $agentService,
        readonly private OpportunityServiceInterface $opportunityService,
        readonly private EventServiceInterface $eventService,
        readonly private SpaceServiceInterface $spaceService,
        readonly private InitiativeServiceInterface $initiativeService,
    ) {
    }

    public function index(): Response
    {
        $totalAgents = $this->agentService->count();
        $totalOpportunities = $this->opportunityService->count();
        $totalEvents = $this->eventService->count();
        $totalSpaces = $this->spaceService->count();
        $totalInitiatives = $this->initiativeService->count();

        $user = $this->getUser();

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'totalAgents' => $totalAgents,
            'totalOpportunities' => $totalOpportunities,
            'totalEvents' => $totalEvents,
            'totalSpaces' => $totalSpaces,
            'totalInitiatives' => $totalInitiatives,
        ]);
    }
}

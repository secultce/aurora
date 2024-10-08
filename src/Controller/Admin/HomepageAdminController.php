<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\EventServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class HomepageAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly AgentServiceInterface $agentService,
        private readonly EventServiceInterface $eventService,
        private readonly InitiativeServiceInterface $initiativeService,
        private readonly OpportunityServiceInterface $opportunityService,
        private readonly SpaceServiceInterface $spaceService,
    ) {
    }

    public function homepage(): Response
    {
        return $this->render('homepage/not-logged.html.twig', [
            'agents' => $this->agentService->list(4),
            'events' => $this->eventService->list(4),
            'initiatives' => $this->initiativeService->list(4),
            'opportunities' => $this->opportunityService->list(4),
            'spaces' => $this->spaceService->list(4),
        ]);
    }
}

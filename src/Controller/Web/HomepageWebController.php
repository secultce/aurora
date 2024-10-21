<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\EventServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class HomepageWebController extends AbstractWebController
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
            'agents' => $this->agentService->list(limit: 4),
            'events' => $this->eventService->list(limit: 4),
            'initiatives' => $this->initiativeService->list(limit: 4),
            'opportunities' => $this->opportunityService->list(limit: 4),
            'spaces' => $this->spaceService->list(limit: 4),
        ]);
    }
}

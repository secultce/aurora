<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\PhaseTimeline;
use App\DocumentService\PhaseTimelineDocumentService;
use App\Service\Interface\PhaseServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class OpportunityPhaseAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly PhaseServiceInterface $phaseService,
        private readonly PhaseTimelineDocumentService $documentService,
        private readonly PhaseTimeline $phaseTimeline
    ) {
    }

    public function timeline(Uuid $opportunityId, Uuid $phaseId): Response
    {
        $events = $this->phaseTimeline->getEvents(
            $this->documentService->getEventsByEntityId($phaseId)
        );

        return $this->render('opportunity-phase/timeline.html.twig', [
            'phase' => $this->phaseService->get($opportunityId, $phaseId),
            'events' => $events,
        ]);
    }
}

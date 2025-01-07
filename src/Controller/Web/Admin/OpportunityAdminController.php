<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\DocumentService\OpportunityTimelineDocumentService;
use App\Service\Interface\InscriptionOpportunityServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class OpportunityAdminController extends AbstractAdminController
{
    public function __construct(
        private OpportunityServiceInterface $service,
        private OpportunityTimelineDocumentService $documentService,
        private InscriptionOpportunityServiceInterface $inscriptionOpportunityService,
    ) {
    }

    public function list(): Response
    {
        $opportunities = $this->service->findBy();

        return $this->render('opportunity/list.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', 'view.opportunity.message.deleted');

        return $this->redirectToRoute('admin_opportunity_list');
    }

    public function timeline(Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        return $this->render('opportunity/timeline.html.twig', [
            'opportunity' => $this->service->get($id),
            'events' => $events,
        ]);
    }

    public function get(Uuid $id): Response
    {
        $inscriptions = $this->inscriptionOpportunityService->list($id);

        return $this->render('opportunity/details.html.twig', [
            'opportunity' => $this->service->get($id),
            'inscriptions' => $inscriptions,
        ]);
    }
}

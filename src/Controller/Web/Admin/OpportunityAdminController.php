<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\EventServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class OpportunityAdminController extends AbstractAdminController
{
    public function __construct(
        private OpportunityServiceInterface $service,
        private AgentServiceInterface $agentService,
        private EventServiceInterface $eventService,
        private InitiativeServiceInterface $initiativeService,
        private SpaceServiceInterface $spaceService,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function create(): Response
    {
        $opportunities = $this->service->findBy();
        $agents = $this->agentService->findBy();
        $events = $this->eventService->findBy();
        $initiatives = $this->initiativeService->findBy();
        $spaces = $this->spaceService->findBy();

        return $this->render('opportunity/create.html.twig', [
            'id' => Uuid::v4()->toRfc4122(),
            'opportunities' => $opportunities,
            'agents' => $agents,
            'events' => $events,
            'initiatives' => $initiatives,
            'spaces' => $spaces,
        ]);
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

    public function store(Request $request): Response
    {
        $data = $request->request->all();

        $this->service->create($data);

        $this->addFlash('success', $this->translator->trans('view.opportunity.message.created'));

        return $this->redirectToRoute('admin_opportunity_list');
    }
}

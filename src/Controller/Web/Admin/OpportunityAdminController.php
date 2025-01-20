<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\DocumentService\OpportunityTimelineDocumentService;
use App\Exception\InscriptionOpportunity\AlreadyInscriptionOpportunityException;
use App\Exception\UnauthorizedException;
use App\Exception\ValidatorException;
use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\EventServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use App\Service\Interface\InscriptionOpportunityServiceInterface;
use App\Service\Interface\OpportunityServiceInterface;
use App\Service\Interface\SpaceServiceInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin/opportunities', name: 'admin_opportunity_')]
class OpportunityAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly OpportunityServiceInterface $service,
        private readonly OpportunityTimelineDocumentService $documentService,
        private readonly AgentServiceInterface $agentService,
        private readonly EventServiceInterface $eventService,
        private readonly InitiativeServiceInterface $initiativeService,
        private readonly SpaceServiceInterface $spaceService,
        private readonly TranslatorInterface $translator,
        private readonly InscriptionOpportunityServiceInterface $inscriptionOpportunityService,
        private readonly Security $security,
    ) {
    }

    #[Route('/adicionar', name: 'create', methods: ['GET'])]
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

    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        $opportunities = $this->service->findBy();

        return $this->render('opportunity/list.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    #[Route('/{id}/remove', name: 'remove', methods: ['GET'])]
    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);
        $this->addFlash('success', 'view.opportunity.message.deleted');

        return $this->redirectToRoute('admin_opportunity_list');
    }

    #[Route('/store', name: 'store', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $data = $request->request->all();
        $data['extraFields']['culturalArea'] = $data['culturalArea'] ?? null;
        unset($data['culturalArea']);

        try {
            $this->service->create($data);
            $this->addFlash('success', $this->translator->trans('view.opportunity.message.created'));
        } catch (ValidatorException $exception) {
            return $this->render('_admin/opportunity/create.html.twig', [
                'errors' => $exception->getConstraintViolationList(),
            ]);
        } catch (Exception $exception) {
            return $this->render('_admin/opportunity/create.html.twig', [
                'errors' => [$exception->getMessage()],
            ]);
        }

        return $this->redirectToRoute('admin_opportunity_list');
    }

    #[Route('/{id}/timeline', name: 'timeline', methods: ['GET'])]
    public function timeline(Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        return $this->render('opportunity/timeline.html.twig', [
            'opportunity' => $this->service->get($id),
            'events' => $events,
        ]);
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function get(Uuid $id): Response
    {
        $inscriptions = $this->inscriptionOpportunityService->list($id);
        $opportunity = $this->service->get($id);
        $phases = $opportunity->getPhases();

        return $this->render('opportunity/details.html.twig', [
            'opportunity' => $opportunity,
            'inscriptions' => $inscriptions,
            'phases' => $phases,
        ]);
    }

    #[Route('/{id}/subscribe', name: 'subscribe', methods: ['GET'])]
    public function subscribe(Uuid $id): Response
    {
        $user = $this->security->getUser();
        if (null === $user) {
            $this->addFlashError($this->translator->trans('view.opportunity.registration_not_logged'));

            return $this->redirectToRoute('web_auth_login');
        }
        $agent = $user->getAgents()->getValues()[0];

        try {
            $this->inscriptionOpportunityService->create($id, [
                'id' => Uuid::v4(),
                'agent' => $agent->getId()->toRfc4122(),
                'status' => 'active',
            ]);
        } catch (AlreadyInscriptionOpportunityException) {
            $this->addFlashError($this->translator->trans('view.opportunity.registration_duplicated'));

            return $this->redirectToRoute('web_opportunity_list');
        } catch (UnauthorizedException) {
            $this->addFlashError($this->translator->trans('view.opportunity.registration_unauthorized'));

            return $this->redirectToRoute('web_opportunity_list');
        }
        $this->addFlashSuccess($this->translator->trans('view.opportunity.registration_success'));

        return $this->redirectToRoute('admin_registration_list');
    }

    #[Route('/{id}/phases/{phaseId}/timeline', name: 'phase_timeline', methods: ['GET'])]
    public function phaseTimeline(Uuid $id, Uuid $phaseId): Response
    {
        $opportunity = $this->service->get($id);
        $phase = null;

        foreach ($opportunity->getPhases() as $p) {
            if ((string) $p->getId() === (string) $phaseId) {
                $phase = $p;
                break;
            }
        }

        return $this->render('opportunity/phase-list.html.twig', [
            'opportunity' => $opportunity,
            'phases' => [$phase],
        ]);
    }
}

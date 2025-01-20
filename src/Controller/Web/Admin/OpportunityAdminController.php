<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\OpportunityTimeline;
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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        private readonly OpportunityTimeline $opportunityTimeline,
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

    public function edit(?Uuid $id, Request $request): Response
    {
        if ('GET' === $request->getMethod()) {
            $opportunity = $this->service->get($id);

            return $this->render('opportunity/edit.html.twig', [
                'opportunity' => $opportunity,
            ]);
        }

        $data = $request->request->all();
        $files = $request->files->all();

        $data['extraFields']['links'] = array_filter(
            $data['extraFields']['links'],
            fn ($link) => '' !== $link['name'] || '' !== $link['url'],
        );

        $data['extraFields']['videos'] = array_filter(
            $data['extraFields']['videos'],
            fn ($video) => '' !== $video['name'] || '' !== $video['url'],
        );

        try {
            $this->service->update($id, $data);
            if ($files['image'] instanceof UploadedFile) {
                $this->service->updateImage($id, $files['image']);
            }
            if ($files['extraFields']['coverImage'] instanceof UploadedFile) {
                $this->service->updateCoverImage($id, $files['extraFields']['coverImage']);
            }

            $this->addFlash('success', $this->translator->trans('view.opportunity.message.updated'));
        } catch (ValidatorException $exception) {
            return $this->render('_admin/opportunity/edit.html.twig', [
                'errors' => $exception->getConstraintViolationList(),
            ]);
        } catch (Exception $exception) {
            return $this->render('_admin/opportunity/edit.html.twig', [
                'errors' => [$exception->getMessage()],
            ]);
        }

        return $this->redirectToRoute('admin_opportunity_list');
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
        $data['extraFields']['culturalArea'] = $data['culturalArea'] ?? null;
        unset($data['culturalArea']);

        [$entity ,$associatedEntity] = explode('_', $data['entity']);
        $data[$entity] = $associatedEntity;
        unset($data['entity']);

        $data['extraFields']['areasOfActivity'] = $data['areasOfActivity'] ?? null;
        unset($data['areasOfActivity']);

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

    public function timeline(Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        $events = $this->opportunityTimeline->getEvents($events);

        return $this->render('opportunity/timeline.html.twig', [
            'opportunity' => $this->service->get($id),
            'events' => $events,
        ]);
    }

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
}

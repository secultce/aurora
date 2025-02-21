<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\SpaceTimeline;
use App\DocumentService\InitiativeTimelineDocumentService;
use App\Exception\ValidatorException;
use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class InitiativeAdminController extends AbstractAdminController
{
    public const CREATE_FORM_ID = 'add-initiative';

    public function __construct(
        private readonly InitiativeServiceInterface $service,
        private readonly InitiativeTimelineDocumentService $documentService,
        private readonly AgentServiceInterface $agentService,
        private readonly TranslatorInterface $translator,
        private readonly SpaceTimeline $spaceTimeline,
    ) {
    }

    public function create(): Response
    {
        $agents = $this->agentService->findBy();

        return $this->render('initiative/create.html.twig', [
            'id' => Uuid::v4()->toRfc4122(),
            'agents' => $agents,
            'form_id' => self::CREATE_FORM_ID,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->validCsrfToken(self::CREATE_FORM_ID, $request);

        $data = $request->request->all();

        try {
            $this->service->create($data);

            $this->addFlash('success', $this->translator->trans('view.initiative.message.created'));
        } catch (ValidatorException $exception) {
            $this->addFlash('error', $this->translator->trans('view.entities.message.required_fields'));

            $agents = $this->agentService->findBy();

            return $this->render('initiative/create.html.twig', [
                'id' => Uuid::v4(),
                'agents' => $agents,
                'form_id' => self::CREATE_FORM_ID,
            ]);
        } catch (Exception $exception) {
            $this->addFlash('error', $this->translator->trans('view.entities.message.required_fields'));

            $agents = $this->agentService->findBy();

            return $this->render('initiative/create.html.twig', [
                'id' => Uuid::v4(),
                'agents' => $agents,
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        return $this->redirectToRoute('admin_initiative_list');
    }

    public function list(): Response
    {
        $initiatives = $this->service->findBy();

        return $this->render('initiative/list.html.twig', [
            'initiatives' => $initiatives,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', 'Initiative removed');

        return $this->redirectToRoute('admin_initiative_list');
    }

    public function timeline(Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        $events = $this->spaceTimeline->getEvents($events);

        return $this->render('initiative/timeline.html.twig', [
            'initiative' => $this->service->get($id),
            'events' => $events,
        ]);
    }
}

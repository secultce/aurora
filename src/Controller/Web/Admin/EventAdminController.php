<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\EventTimeline;
use App\DocumentService\EventTimelineDocumentService;
use App\Service\Interface\CulturalLanguageServiceInterface;
use App\Service\Interface\EventServiceInterface;
use App\Service\Interface\TagServiceInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;
use TypeError;

class EventAdminController extends AbstractAdminController
{
    private const VIEW_ADD = 'event/create.html.twig';
    public const CREATE_FORM_ID = 'add-event';
    public const EDIT_FORM_ID = 'edit-event';

    public function __construct(
        private EventServiceInterface $service,
        private readonly TranslatorInterface $translator,
        private readonly EventTimelineDocumentService $documentService,
        private readonly Security $security,
        private readonly EventTimeline $eventTimeline,
        private readonly TagServiceInterface $tagService,
        private readonly CulturalLanguageServiceInterface $culturalLanguageService,
    ) {
    }

    public function list(): Response
    {
        $events = $this->service->findBy();

        return $this->render('event/list.html.twig', [
            'events' => $events,
        ]);
    }

    public function timeline(?Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        return $this->render('event/timeline.html.twig', [
            'event' => $this->service->get($id),
            'events' => $events,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', $this->translator->trans('view.event.message.deleted'));

        return $this->redirectToRoute('admin_event_list');
    }

    public function create(Request $request): Response
    {
        if (false === $request->isMethod('POST')) {
            return $this->render(self::VIEW_ADD, [
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        $this->validCsrfToken(self::CREATE_FORM_ID, $request);

        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $ageRating = $request->request->get('age_rating');
        $culturalLanguage = $request->request->get('cultural_language');
        $type = $request->request->get('type');
        $endDate = $request->request->get('end_date');
        $maxCapacity = (int) $request->request->get('max_capacity');

        $event = [
            'id' => Uuid::v4(),
            'name' => $name,
            'description' => $description,
            'extraFields' => [
                'age_rating' => $ageRating,
                'cultural_language' => $culturalLanguage,
            ],
            'agentGroup' => null,
            'type' => $type,
            'endDate' => $endDate,
            'maxCapacity' => $maxCapacity,
        ];

        try {
            $this->service->create($event);
            $this->addFlashSuccess($this->translator->trans('view.event.message.created'));
        } catch (TypeError $exception) {
            $this->addFlash('error', $exception->getMessage());

            return $this->render(self::VIEW_ADD, [
                'error' => $exception->getMessage(),
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        return $this->list();
    }

    public function edit(Uuid $id, Request $request): Response
    {
        try {
            $event = $this->service->get($id);
        } catch (Exception $exception) {
            $this->addFlash('error', $exception->getMessage());

            return $this->redirectToRoute('admin_event_list');
        }

        if (Request::METHOD_POST !== $request->getMethod()) {
            $culturalLanguageItems = $this->culturalLanguageService->list();
            $tagItems = $this->tagService->list();

            return $this->render('event/edit.html.twig', [
                'event' => $event,
                'form_id' => self::EDIT_FORM_ID,
                'culturalLanguageItems' => $culturalLanguageItems,
                'tagItems' => $tagItems,
            ]);
        }

        $this->validCsrfToken(self::EDIT_FORM_ID, $request);

        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $ageRating = $request->request->get('age_rating') ?? null;
        $type = $request->request->get('type');
        $maxCapacity = (int) $request->request->get('max_capacity') ?? null;
        $culturalLanguages = $request->get('culturalLanguages') ?? [];
        $tags = $request->get('tags') ?? [];

        $dataToUpdate = [
            'name' => $name,
            'description' => $description,
            'extraFields' => [
                'age_rating' => $ageRating,
            ],
            'agentGroup' => null,
            'type' => $type,
            'maxCapacity' => $maxCapacity,
            'culturalLanguages' => $culturalLanguages,
            'tags' => $tags,
            'updatedBy' => $this->security->getUser()->getAgents()->getValues()[0]->getId(),
        ];

        try {
            $this->service->update($id, $dataToUpdate);

            $this->addFlashSuccess($this->translator->trans('view.event.message.updated'));

            return $this->redirectToRoute('admin_event_list');
        } catch (TypeError|Exception $exception) {
            $this->addFlashError($exception->getMessage());

            return $this->render('event/edit.html.twig', [
                'event' => $event,
                'error' => $exception->getMessage(),
                'form_id' => self::EDIT_FORM_ID,
            ]);
        }
    }
}

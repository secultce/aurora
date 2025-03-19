<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\EventTimeline;
use App\DocumentService\EventTimelineDocumentService;
use App\Service\Interface\EventServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;
use TypeError;

class EventAdminController extends AbstractAdminController
{
    private const VIEW_ADD = 'event/create.html.twig';

    public const CREATE_FORM_ID = 'add-event';

    public function __construct(
        private EventServiceInterface $service,
        private readonly TranslatorInterface $translator,
        private readonly EventTimelineDocumentService $documentService,
        private readonly EventTimeline $eventTimeline,
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
        } catch (TypeError $exception) {
            $this->addFlash('error', $exception->getMessage());

            return $this->render(self::VIEW_ADD, [
                'error' => $exception->getMessage(),
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        return $this->list();
    }

    public function edit(Uuid $id): Response
    {
        $event = $this->service->get($id);

        return $this->render('event/edit.html.twig', [
            'event' => $event,
        ]);
    }
}

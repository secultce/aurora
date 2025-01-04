<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

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

    public function __construct(
        private EventServiceInterface $service,
        private readonly TranslatorInterface $translator,
        private readonly EventTimelineDocumentService $documentService
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
        $timelineEvents = $this->documentService->getEventsByEntityId($id);

        return $this->render('event/timeline.html.twig', [
            'event' => $this->service->get($id),
            'events' => $timelineEvents,
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
            return $this->render(self::VIEW_ADD);
        }

        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $ageRating = $request->request->get('age_rating');
        $culturalLanguage = $request->request->get('cultural_language');

        $event = [
            'id' => Uuid::v4(),
            'name' => $name,
            'description' => $description,
            'extraFields' => [
                'age_rating' => $ageRating,
                'cultural_language' => $culturalLanguage,
            ],
            'agentGroup' => null,
        ];

        try {
            $this->service->create($event);
        } catch (TypeError $exception) {
            $this->addFlash('error', $exception->getMessage());

            return $this->render(self::VIEW_ADD, [
                'error' => $exception->getMessage(),
            ]);
        }

        return $this->list();
    }
}

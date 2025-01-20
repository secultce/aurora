<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\EventTimeline;
use App\DocumentService\EventTimelineDocumentService;
use App\Exception\ValidatorException;
use App\Service\Interface\EventServiceInterface;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;
use TypeError;

class EventAdminController extends AbstractAdminController
{
    private const VIEW_ADD = 'event/create.html.twig';
    private const VIEW_EDIT = 'event/edit.html.twig';

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
        $timelineEvents = $this->documentService->getEventsByEntityId($id);

        $events = $this->eventTimeline->getEvents($timelineEvents);

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

    public function edit(?Uuid $id, Request $request): Response
    {
        $event = $this->service->get($id);
        return $this->render(self::VIEW_EDIT, [
            'event' => $event,
        ]);
    }
    public function update(Request $request, Uuid $id): Response
    {
        //dd($request->request->all());
        $data = $request->request->all();
//        dd($data['event-name']);
        $event = $this->service->get($id);

//        $image = $data['cover-image'];
        $name = $data['event-name'];
        $subtitle = ['event-subtitle'];
        $shortDescription = $data['short-description'];
        $longDescription = $data['long-description'];
        $siteUrl = $data['site-url'];
        $linkDescription = $data['link-description'];
        $ageRating = $data['age-rating'];
//        $culturalLanguage = $data['culturalArea'];

        $dataToUpdate = [
            'name' => $name,
            'extraFields' => [
              'subtitle' => $subtitle,
              'short_description' => $shortDescription,
              'long_description' => $longDescription,
              'site_url' => $siteUrl,
              'link_description' => $linkDescription,
              'age_rating' => $ageRating,
//              'cultural_language' => $culturalLanguage,
            ],
        ];

        try {
            $this->service->update($id, $dataToUpdate);

            $this->addFlashSuccess('success', $this->translator->trans('view.event.message.updated'));
        } catch (ValidatorException $exception) {
            $this->addFlashError('error', $this->translator->trans('view.event.message.updated'));

            return $this->render(self::VIEW_EDIT, [
                'event' => $event,
                'error' => $exception->getMessage(),
            ]);
        }

        catch (Exception $exception) {
            $this->addFlashError('error', $this->translator->trans('view.entities.message.required_fields'));

            $events = $this->render('_admin/event/edit.html.twig');

            return $this->render('_admin/event/edit.html.twig', [
                'id' => Uuid::v4(),
                'events' => $events,
            ]);
        }

        return $this->redirectToRoute('admin_event_list');
    }
}

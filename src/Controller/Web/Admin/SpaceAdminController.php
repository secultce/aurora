<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\SpaceTimeline;
use App\DocumentService\SpaceTimelineDocumentService;
use App\Service\Interface\SpaceServiceInterface;
use DateTime;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;
use TypeError;

class SpaceAdminController extends AbstractAdminController
{
    private const VIEW_LIST = 'space/list.html.twig';
    private const VIEW_ADD = 'space/create.html.twig';
    private const VIEW_EDIT = 'space/edit.html.twig';

    public function __construct(
        private readonly SpaceServiceInterface $service,
        private readonly SpaceTimelineDocumentService $documentService,
        private readonly TranslatorInterface $translator,
        private readonly Security $security,
        private readonly SpaceTimeline $spaceTimeline,
    ) {
    }

    public function list(): Response
    {
        $spaces = $this->service->findBy();

        return $this->render(self::VIEW_LIST, [
            'spaces' => $spaces,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlashSuccess($this->translator->trans('view.space.message.deleted'));

        return $this->redirectToRoute('admin_space_list');
    }

    public function create(Request $request): Response
    {
        if (false === $request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::VIEW_ADD);
        }

        $name = $request->request->get('name');
        $maxCapacity = (int) $request->request->get('maxCapacity');
        $isAccessible = (bool) $request->request->get('isAccessible');

        $space = [
            'id' => Uuid::v4(),
            'name' => $name,
            'maxCapacity' => $maxCapacity,
            'isAccessible' => $isAccessible,
            'createdBy' => $this->security->getUser()->getAgents()->getValues()[0]->getId(),
        ];

        try {
            $this->service->create($space);
            $this->addFlashSuccess($this->translator->trans('view.space.message.created'));
        } catch (TypeError $exception) {
            $this->addFlashError($exception->getMessage());

            return $this->render(self::VIEW_ADD, [
                'error' => $exception->getMessage(),
            ]);
        }

        return $this->redirectToRoute('admin_space_list');
    }

    public function timeline(Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        $events = $this->spaceTimeline->getEvents($events);

        return $this->render('space/timeline.html.twig', [
            'space' => $this->service->get($id),
            'events' => $events,
        ]);
    }

    public function edit(Uuid $id, Request $request): Response
    {
        try {
            $space = $this->service->get($id);
        } catch (Exception $exception) {
            $this->addFlashError($exception->getMessage());

            return $this->redirectToRoute('admin_space_list');
        }

        if (Request::METHOD_POST !== $request->getMethod()) {
            return $this->render(self::VIEW_EDIT, [
                'space' => $space,
            ]);
        }

        $name = $request->request->get('name');
        $description = $request->request->get('extraFields')['description'] ?? null;
        $date = $request->request->get('date') ?? null;

        $dataToUpdate = [
            'name' => $name,
            'description' => $description,
            'date' => $date ? new DateTime($date) : null,
            'updatedBy' => $this->security->getUser()->getAgents()->getValues()[0]->getId(),
        ];

        try {
            $this->service->update($id, $dataToUpdate);

            $this->addFlashSuccess($this->translator->trans('view.space.message.updated'));

            return $this->redirectToRoute('admin_space_list');
        } catch (TypeError|Exception $exception) {
            $this->addFlashError($exception->getMessage());

            return $this->render(self::VIEW_EDIT, [
                'space' => $space,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\DocumentService\SpaceTimelineDocumentService;
use App\Service\Interface\SpaceServiceInterface;
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

    public function __construct(
        private readonly SpaceServiceInterface $service,
        private readonly SpaceTimelineDocumentService $documentService,
        private readonly TranslatorInterface $translator,
        private readonly Security $security,
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

        $space = [
            'id' => Uuid::v4(),
            'name' => $name,
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

        return $this->render('space/timeline.html.twig', [
            'space' => $this->service->get($id),
            'events' => $events,
        ]);
    }
}

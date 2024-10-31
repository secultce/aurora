<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\EventServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class EventAdminController extends AbstractAdminController
{
    public function __construct(
        private EventServiceInterface $service,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function list(): Response
    {
        $events = $this->service->findBy();

        return $this->render('event/list.html.twig', [
            'events' => $events,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', $this->translator->trans('view.event.message.deleted'));

        return $this->redirectToRoute('admin_event_list');
    }
}

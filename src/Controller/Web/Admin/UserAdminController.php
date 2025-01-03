<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\DocumentService\UserTimelineDocumentService;
use App\Service\Interface\UserServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class UserAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly UserTimelineDocumentService $documentService,
        private readonly UserServiceInterface $service,
    ) {
    }

    public function list(): Response
    {
        $users = $this->service->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    public function timeline(Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        return $this->render('user/timeline.html.twig', [
            'user' => $this->service->get($id),
            'events' => $events,
        ]);
    }
}

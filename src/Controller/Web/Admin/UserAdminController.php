<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\UserTimeline;
use App\DocumentService\AuthTimelineDocumentService;
use App\DocumentService\UserTimelineDocumentService;
use App\Service\Interface\UserServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class UserAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly UserTimelineDocumentService $documentService,
        private readonly UserServiceInterface $service,
        private readonly UserTimeline $userTimeline,
        private readonly AuthTimelineDocumentService $authDocumentService,
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

        $authEvents = $this->authDocumentService->getTimelineLoginByUserId($id);

        return $this->render('user/timeline.html.twig', [
            'user' => $this->service->get($id),
            'events' => $events,
            'authEvents' => $authEvents,
        ]);
    }

    public function accountPrivacy(Uuid $id): Response
    {
        $user = $this->service->get($id);

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $lastLogin = $this->documentService->getLastLoginByUserId($id);

        return $this->render('user/account-privacy.html.twig', [
            'user' => [
                'name' => $user->getName(),
                'id' => $user->getId(),
                'isActive' => $user->isActive(),
                'lastLogin' => $lastLogin,
                'createdAt' => $user->getCreatedAt(),
                'email' => $user->getEmail(),
                'acceptedTerms' => null !== $user->getUpdatedAt(),
                'acceptedTermsDate' => $user->getUpdatedAt(),
            ],
        ]);
    }
}

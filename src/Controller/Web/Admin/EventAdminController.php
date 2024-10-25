<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\EventServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class EventAdminController extends AbstractAdminController
{
    public function __construct(
        private EventServiceInterface $service
    ) {
    }

    public function list(): Response
    {
        $events = $this->service->list([
            // 'createdBy' => $this->getUser()->getId(),
        ]);

        return $this->render('event/list.html.twig', [
            'events' => $events,
        ]);
    }
}

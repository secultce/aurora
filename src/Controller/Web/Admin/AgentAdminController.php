<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\AgentServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class AgentAdminController extends AbstractAdminController
{
    public function __construct(
        private AgentServiceInterface $service
    ) {
    }

    public function list(): Response
    {
        $agents = $this->service->list([
            // 'createdBy' => $this->getUser()->getId(),
        ]);

        return $this->render('agent/list.html.twig', [
            'agents' => $agents,
        ]);
    }
}

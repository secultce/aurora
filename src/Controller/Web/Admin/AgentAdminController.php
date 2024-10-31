<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\AgentServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class AgentAdminController extends AbstractAdminController
{
    public function __construct(
        private AgentServiceInterface $service
    ) {
    }

    public function list(): Response
    {
        $agents = $this->service->findBy();

        return $this->render('agent/list.html.twig', [
            'agents' => $agents,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', 'view.agent.message.deleted');

        return $this->redirectToRoute('admin_agent_list');
    }
}

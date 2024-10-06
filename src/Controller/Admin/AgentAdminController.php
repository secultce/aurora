<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\AgentServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class AgentAdminController extends AbstractAdminController
{
    public function __construct(
        public readonly AgentServiceInterface $service,
    ) {
    }

    public function list(): Response
    {
        $agents = $this->service->list();
        $totalAgents = count($agents);

        $entity = [
            'color' => '#D0A020',
            'items' => [
                ['text' => 'agent.registered_agents', 'icon' => 'description', 'quantity' => $totalAgents],
                ['text' => 'agent.individual_agents', 'icon' => 'event_note', 'quantity' => 32],
                ['text' => 'agent.collective_agents', 'icon' => 'event_available', 'quantity' => 12],
                ['text' => 'agent.registered_last_7_days', 'icon' => 'today', 'quantity' => 1],
            ],
        ];

        return $this->render('agent/list.html.twig', [
            'agent' => $entity,
            'agents' => $agents,
            'totalAgents' => $totalAgents,
        ]);
    }
}

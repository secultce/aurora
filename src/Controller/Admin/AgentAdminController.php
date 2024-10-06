<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\AgentServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
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

        $dashboard = [
            'color' => '#D0A020',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalAgents, text: 'agent.registered_agents'),
                new CardItem(icon: 'event_note', quantity: 30, text: 'agent.individual_agents'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'agent.collective_agents'),
                new CardItem(icon: 'today', quantity: 10, text: 'agent.registered_last_7_days'),
            ],
        ];

        return $this->render('agent/list.html.twig', [
            'dashboard' => $dashboard,
            'agents' => $agents,
            'totalAgents' => $totalAgents,
        ]);
    }
}

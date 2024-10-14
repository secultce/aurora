<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Service\Interface\AgentServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Response;

class AgentWebController extends AbstractWebController
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
                new CardItem(icon: 'description', quantity: $totalAgents, text: 'view.agent.quantity.total'),
                new CardItem(icon: 'person', quantity: 30, text: 'view.agent.quantity.culture'),
                new CardItem(icon: 'block', quantity: 20, text: 'view.agent.quantity.inactive'),
                new CardItem(icon: 'today', quantity: 10, text: 'view.agent.quantity.last_days'),
            ],
        ];

        return $this->render('agent/list.html.twig', [
            'dashboard' => $dashboard,
            'agents' => $agents,
            'totalAgents' => $totalAgents,
        ]);
    }
}

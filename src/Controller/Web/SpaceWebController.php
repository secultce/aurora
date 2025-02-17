<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\SpaceServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class SpaceWebController extends AbstractWebController
{
    public function __construct(
        public readonly SpaceServiceInterface $service,
        public readonly AgentServiceInterface $agentService,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function list(Request $request): Response
    {
        $filters = $request->query->all();

        $filters = $this->getOrderParam($filters);

        $spaces = $this->service->list(params: $filters['filters'], order: $filters['order']);
        $totalSpaces = count($spaces);

        $days = $request->get('days', 7);
        $recentSpaces = $this->service->countRecentRecords($days);

        $dashboard = [
            'color' => '#088140',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalSpaces, text: 'view.space.quantity.total'),
                new CardItem(icon: 'event_note', quantity: 10, text: 'view.space.quantity.opened'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'view.space.quantity.finished'),
                new CardItem(icon: 'today', quantity: $recentSpaces, text: $this->translator->trans('view.space.quantity.last_days', ['{days}' => $days])),
            ],
        ];

        return $this->render('space/list.html.twig', [
            'spaces' => $spaces,
            'dashboard' => $dashboard,
            'totalSpaces' => $totalSpaces,
        ]);
    }

    public function getOne(Uuid $id): Response
    {
        $space = $this->service->get($id);
        $owner = $this->agentService->get($space->getCreatedBy()->getId());

        return $this->render('space/one.html.twig', [
            'space' => $space,
            'owner' => $owner,
        ]);
    }
}

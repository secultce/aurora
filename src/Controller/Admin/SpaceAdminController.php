<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\SpaceServiceInterface;
use App\ValueObject\DashboardCardItemValueObject as CardItem;
use Symfony\Component\HttpFoundation\Response;

class SpaceAdminController extends AbstractAdminController
{
    private SpaceServiceInterface $spaceService;

    public function __construct(SpaceServiceInterface $spaceService)
    {
        $this->spaceService = $spaceService;
    }

    public function list(): Response
    {
        $spaces = $this->spaceService->list();
        $totalSpaces = count($spaces);

        $dashboard = [
            'color' => '#8E46B4',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalSpaces, text: 'space.dashboard.registered'),
                new CardItem(icon: 'event_note', quantity: 10, text: 'space.dashboard.realized'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'space.dashboard.finished'),
                new CardItem(icon: 'today', quantity: 30, text: 'space.dashboard.seven.days.registered'),
            ],
        ];

        return $this->render('space/list.html.twig', [
            'spaces' => $spaces,
            'dashboard' => $dashboard,
        ]);
    }
}

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
            'color' => '#088140',
            'items' => [
                new CardItem(icon: 'description', quantity: $totalSpaces, text: 'view.space.quantity.total'),
                new CardItem(icon: 'event_note', quantity: 10, text: 'view.space.quantity.opened'),
                new CardItem(icon: 'event_available', quantity: 20, text: 'view.space.quantity.finished'),
                new CardItem(icon: 'today', quantity: 30, text: 'view.space.quantity.last_days'),
            ],
        ];

        return $this->render('space/list.html.twig', [
            'spaces' => $spaces,
            'dashboard' => $dashboard,
            'totalSpaces' => $totalSpaces,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class SpaceAdminController extends AbstractAdminController
{
    private SpaceServiceInterface $spaceService;

    public function __construct(SpaceServiceInterface $spaceService)
    {
        $this->spaceService = $spaceService;
    }

    public function space(): Response
    {
        $spaces = $this->spaceService->list();

        return $this->render('space/space-list.html.twig', [
            'spaces' => $spaces,
        ]);
    }
}

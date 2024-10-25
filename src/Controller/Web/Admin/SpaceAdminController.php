<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\SpaceServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class SpaceAdminController extends AbstractAdminController
{
    public function __construct(
        private SpaceServiceInterface $service
    ) {
    }

    public function list(): Response
    {
        $spaces = $this->service->list([
            // 'createdBy' => $this->getUser()->getId(),
        ]);

        return $this->render('space/list.html.twig', [
            'spaces' => $spaces,
        ]);
    }
}

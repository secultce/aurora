<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\InitiativeServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class InitiativeAdminController extends AbstractAdminController
{
    public function __construct(
        private InitiativeServiceInterface $service
    ) {
    }

    public function list(): Response
    {
        $initiatives = $this->service->list([
            // 'createdBy' => $this->getUser()->getId(),
        ]);

        return $this->render('initiative/list.html.twig', [
            'initiatives' => $initiatives,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Interface\InitiativeServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class InitiativeAdminController extends AbstractAdminController
{
    private InitiativeServiceInterface $initiativeService;

    public function __construct(InitiativeServiceInterface $initiativeService)
    {
        $this->initiativeService = $initiativeService;
    }

    public function list(): Response
    {
        $initiatives = $this->initiativeService->list();

        return $this->render('initiative/initiative.html.twig', [
            'initiatives' => $initiatives,
        ]);
    }
}

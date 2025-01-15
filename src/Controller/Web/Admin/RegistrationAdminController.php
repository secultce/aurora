<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\InscriptionOpportunityServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class RegistrationAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly InscriptionOpportunityServiceInterface $service,
    ) {
    }

    public function list(): Response
    {
        $inscriptions = $this->service->findUserInscriptionsWithDetails();

        return $this->render('registration/list.html.twig', [
            'inscriptions' => $inscriptions,
        ]);
    }
}

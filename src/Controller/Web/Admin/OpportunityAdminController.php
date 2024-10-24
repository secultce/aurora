<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\OpportunityServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class OpportunityAdminController extends AbstractAdminController
{
    public function __construct(
        private OpportunityServiceInterface $service,
    ) {
    }

    public function list(): Response
    {
        $opportunities = $this->service->myOpportunities($this->getUser());

        return $this->render('opportunity/list.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Interface\DetailsOpportunityServiceInterface;

class DetailsOpportunityWebController extends AbstractWebController
{
    public function __construct(
        private readonly DetailsOpportunityServiceInterface $detailsOpportunityService
    ) {

    }

    public function list(Request $request): Response
    {
        $opportunityId = $request->query->get('id', 'default-id'); // Sem linhas em branco antes ou depois

        $opportunity = $this->detailsOpportunityService->findDetailsById($opportunityId);

        if (!$opportunity) {
            throw $this->createNotFoundException('Oportunidade não encontrada.');
        }

        return $this->render('details-opportunity/list.html.twig', [
            'opportunity' => $opportunity,
        ]);
    }

}
<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\OpportunityServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class OpportunityAdminController extends AbstractAdminController
{
    public function __construct(
        private OpportunityServiceInterface $service,
    ) {
    }

    public function list(): Response
    {
        $opportunities = $this->service->findBy();

        return $this->render('opportunity/list.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    public function edit(?Uuid $id): Response
    {
        $opportunity = $this->service->get($id);

        return $this->render('opportunity/edit.html.twig', [
            'opportunity' => $opportunity,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', 'view.opportunity.message.deleted');

        return $this->redirectToRoute('admin_opportunity_list');
    }
}

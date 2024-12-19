<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\OpportunityServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Contracts\Translation\TranslatorInterface;

class OpportunityAdminController extends AbstractAdminController
{
    public function __construct(
        private OpportunityServiceInterface $service,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function create(): Response
    {
        $opportunities = $this->service->findBy();

        return $this->render('opportunity/create.html.twig', [
            'id' => Uuid::v4()->toRfc4122(),
            'opportunities' => $opportunities,
        ]);
    }

    public function list(): Response
    {
        $opportunities = $this->service->findBy();

        return $this->render('opportunity/list.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', 'view.opportunity.message.deleted');

        return $this->redirectToRoute('admin_opportunity_list');
    }

    public function store(Request $request): Response
    {
        $data = $request->request->all();

        $this->service->create($data);

        $this->addFlash('success', $this->translator->trans('view.opportunity.message.created'));

        return $this->redirectToRoute('admin_opportunity_list');
    }
}

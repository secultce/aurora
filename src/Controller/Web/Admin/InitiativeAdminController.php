<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\AgentServiceInterface;
use App\Service\Interface\InitiativeServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Contracts\Translation\TranslatorInterface;

class InitiativeAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly InitiativeServiceInterface $service,
        private readonly AgentServiceInterface $agentService,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function create(): Response
    {
        $agents = $this->agentService->findBy();

        return $this->render('initiative/create.html.twig', [
            'id' => Uuid::v4()->toRfc4122(),
            'agents' => $agents,
        ]);
    }

    public function store(Request $request): Response
    {
        $data = $request->request->all();

        $initiative = $this->service->create($data);

        if ($initiative instanceof ConstraintViolationList) {
            $this->addFlash('error', $this->translator->trans('view.initiative.message.required_fields'));

            return $this->redirectToRoute('admin_initiative_create');
        }

        $this->addFlash('success', $this->translator->trans('view.initiative.message.created'));

        return $this->redirectToRoute('admin_initiative_list');
    }

    public function list(): Response
    {
        $initiatives = $this->service->findBy();

        return $this->render('initiative/list.html.twig', [
            'initiatives' => $initiatives,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', 'Initiative removed');

        return $this->redirectToRoute('admin_initiative_list');
    }
}

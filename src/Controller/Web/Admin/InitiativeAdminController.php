<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\InitiativeServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class InitiativeAdminController extends AbstractAdminController
{
    public function __construct(
        private readonly InitiativeServiceInterface $service,
    ) {
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

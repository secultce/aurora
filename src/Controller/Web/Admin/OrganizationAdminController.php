<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\OrganizationServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrganizationAdminController extends AbstractAdminController
{
    public function __construct(
        private OrganizationServiceInterface $service,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function list(): Response
    {
        $organizations = $this->service->findBy();

        return $this->render('organization/list.html.twig', [
            'organizations' => $organizations,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', $this->translator->trans('view.organization.message.deleted'));

        return $this->redirectToRoute('admin_organization_list');
    }
}

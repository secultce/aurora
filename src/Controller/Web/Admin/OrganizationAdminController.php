<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\OrganizationServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class OrganizationAdminController extends AbstractAdminController
{
    public function __construct(
        private OrganizationServiceInterface $service
    ) {
    }

    public function list(): Response
    {
        $organizations = $this->service->findBy();

        return $this->render('organization/list.html.twig', [
            'organizations' => $organizations,
        ]);
    }
}

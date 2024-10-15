<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use Symfony\Component\HttpFoundation\Response;

class DashboardAdminController extends AbstractAdminController
{
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }
}

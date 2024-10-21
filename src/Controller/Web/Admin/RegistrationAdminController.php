<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use Symfony\Component\HttpFoundation\Response;

class RegistrationAdminController extends AbstractAdminController
{
    public function list(): Response
    {
        return $this->render('registration/list.html.twig');
    }
}

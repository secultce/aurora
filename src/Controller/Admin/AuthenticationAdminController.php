<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class AuthenticationAdminController extends AbstractAdminController
{
    public function login(): Response
    {
        return $this->render('authentication/login.html.twig');
    }
}

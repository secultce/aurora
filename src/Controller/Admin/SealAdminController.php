<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class SealAdminController extends AbstractAdminController
{
    public function list(): Response
    {
        return $this->render('seal/list.html.twig');
    }
}

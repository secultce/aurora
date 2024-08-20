<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class HomepageAdminController extends AbstractAdminController
{
    public function homepage(): Response
    {
        return $this->render('homepage/not-logged.html.twig');
    }
}

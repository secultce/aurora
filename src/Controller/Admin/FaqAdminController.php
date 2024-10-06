<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class FaqAdminController extends AbstractAdminController
{
    public function faq(): Response
    {
        return $this->render('faq/faq.html.twig');
    }
}

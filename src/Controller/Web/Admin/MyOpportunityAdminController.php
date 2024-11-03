<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use Symfony\Component\HttpFoundation\Response;

class MyOpportunityAdminController extends AbstractAdminController
{
    public function list(): Response
    {
        return $this->render('my-opportunity/list.html.twig');
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class ExampleAdminController extends AbstractAdminController
{
    public function action(): Response
    {
        return $this->render('example/action.html.twig', [
            'name' => 'Mapinha',
        ]);
    }
}

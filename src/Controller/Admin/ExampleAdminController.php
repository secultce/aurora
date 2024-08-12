<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ExampleAdminController extends AbstractController
{
    public function action(): Response
    {
        return $this->render('admin/example/action.html.twig', [
            'name' => 'Mapinha',
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractAdminController extends AbstractController
{
    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        return parent::render("admin/{$view}", $parameters, $response);
    }
}

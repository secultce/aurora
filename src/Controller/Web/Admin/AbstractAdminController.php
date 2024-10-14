<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Controller\Web\AbstractWebController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractAdminController extends AbstractWebController
{
    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        return parent::render("_admin/{$view}", $parameters, $response);
    }
}

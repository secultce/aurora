<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\Response;

class SuccessWebController extends AbstractWebController
{
    public function success(): Response
    {
        return $this->render('success/success.html.twig');
    }
}

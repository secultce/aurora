<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\Response;

class FaqWebController extends AbstractWebController
{
    public function faq(): Response
    {
        return $this->render('faq/faq.html.twig');
    }
}

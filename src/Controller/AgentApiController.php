<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgentApiController
{
    #[Route('/agent', name: 'rota_exemplo')]
    public function exemplo(): Response
    {
        return new Response('oi som');
    }
}
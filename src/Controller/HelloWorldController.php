<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController
{
    #[Route('/hello', name: 'rota_exemplo')]
    public function exemplo(): Response
    {
        return new Response('Bem vinde ao Mapas Culturais CE');
    }
}
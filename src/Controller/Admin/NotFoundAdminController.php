<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class NotFoundAdminController extends AbstractController
{
    public function handleNotFound(string $url): Response
    {
        if (strpos($url, '/api') === 0) {
            return new JsonResponse(['error' => 'API endpoint not found'], Response::HTTP_NOT_FOUND);
        }
        return $this->render('errors/404.html.twig', [], new Response('', Response::HTTP_NOT_FOUND));
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

abstract class AbstractWebController extends AbstractController
{
    public function getOrderParam(array $filters): array
    {
        $order = 'DESC';

        if (isset($filters['order']) && in_array($filters['order'], ['ASC', 'DESC'])) {
            $order = $filters['order'];
        }

        unset($filters['order']);

        return ['order' => $order, 'filters' => $filters];
    }

    protected function validCsrfToken(string $tokenId, Request $request): void
    {
        if (false === $request->isMethod(Request::METHOD_POST)) {
            return;
        }

        $submittedToken = $request->getPayload()->get('token');

        if (false === $this->isCsrfTokenValid($tokenId, $submittedToken)) {
            throw new InvalidCsrfTokenException();
        }
    }
}

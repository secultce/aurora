<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\UserServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class UserAdminController extends AbstractAdminController
{
    public function __construct(
        private UserServiceInterface $service
    ) {
    }

    public function list(): Response
    {
        $users = $this->service->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
}

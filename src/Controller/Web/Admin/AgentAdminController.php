<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Service\Interface\AgentServiceInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class AgentAdminController extends AbstractAdminController
{
    public function __construct(
        private AgentServiceInterface $service,
        private JWTTokenManagerInterface $jwtManager
    ) {
    }

    public function list(UserInterface $user): Response
    {
        $agents = $this->service->findBy();

        $token = $this->jwtManager->create($user);

        return $this->render('agent/list.html.twig', [
            'agents' => $agents,
            'token' => $token,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', 'view.agent.message.deleted');

        return $this->redirectToRoute('admin_agent_list');
    }
}

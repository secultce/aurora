<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\Agent;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class AbstractFixture extends Fixture
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TokenStorageInterface $tokenStorage,
    ) {
    }

    public function manualLogin(string $id): void
    {
        $user = $this->entityManager->find(User::class, $id);
        $token = new UsernamePasswordToken($user, 'web');
        $this->tokenStorage->setToken($token);
    }

    public function manualLoginByAgent(string $id): void
    {
        $agent = $this->entityManager->find(Agent::class, $id);
        $this->manualLogin($agent->getUser()->getId()->toRfc4122());
    }

    public function manualLogout(): void
    {
        $this->tokenStorage->setToken(null);
    }
}

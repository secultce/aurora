<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationApiController extends AbstractApiController
{
    public function __construct(
        private readonly JWTTokenManagerInterface $jwtManager,
        private readonly EntityManagerInterface $manager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function login(Request $request): JsonResponse
    {
        $request = $request->toArray();

        $username = $request['username'];
        $password = $request['password'];

        $user = $this->validateUser($username, $password);

        if (null === $user) {
            return new JsonResponse([
                'message' => 'unauthorized',
                'details' => [
                    'The credentials you provided are invalid. Please try again.',
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $this->jwtManager->create($user);

        return new JsonResponse(['token' => $token, 'user' => $user->getUserIdentifier()]);
    }

    private function validateUser(string $username, string $password): ?UserInterface
    {
        $userRepository = $this->manager->getRepository(User::class);

        $user = $userRepository->findOneBy(['email' => $username]);

        if (null === $user) {
            return null;
        }

        if (false === $this->passwordHasher->isPasswordValid($user, $password)) {
            return null;
        }

        return $user;
    }
}

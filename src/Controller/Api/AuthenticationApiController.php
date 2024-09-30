<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationApiController extends AbstractApiController
{
    public function __construct(
        private readonly JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function login(): JsonResponse
    {
        $user = $this->getUser();

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
}

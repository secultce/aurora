<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;

class LogoutApiController extends AbstractApiController
{
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly string $jwtPublicKey,
    ) {
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->headers->get('Authorization');

        if ($token) {
            $token = str_replace('Bearer ', '', $token);
            $expirationTime = $this->getTokenExpirationTime($token);

            $this->cache->get("blacklist_{$token}", function () {
                return true;
            }, $expirationTime);

            return new JsonResponse(['message' => 'Logged out successfully'], Response::HTTP_OK);
        }

        return new JsonResponse(['message' => 'Token not provided'], Response::HTTP_BAD_REQUEST);
    }

    private function getTokenExpirationTime(string $token): int
    {
        $publicKey = file_get_contents($this->getParameter('jwt_public_key'));

        $decodedToken = JWT::decode($token, new Key($publicKey, 'RS256'));

        $remainingTime = $decodedToken->exp - time();

        var_dump([
            'current_time' => time(),
            'expiration_time' => $decodedToken->exp,
            'remaining_time' => $remainingTime
        ]);

        return $decodedToken->exp - time();
    }

}

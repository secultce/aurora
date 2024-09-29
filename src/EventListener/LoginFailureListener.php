<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

#[AsEventListener(LoginFailureEvent::class, 'onLoginFailure')]
class LoginFailureListener
{
    public function onLoginFailure(LoginFailureEvent $event): void
    {
        if ('json_login' !== $event->getFirewallName()) {
            return;
        }

        $data = [
            'message' => 'unauthorized',
            'details' => [
                'The credentials you provided are invalid. Please try again.',
            ],
        ];

        $response = new JsonResponse($data, Response::HTTP_UNAUTHORIZED);

        $event->setResponse($response);
    }
}

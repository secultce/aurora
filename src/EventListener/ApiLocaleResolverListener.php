<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(KernelEvents::REQUEST, 'resolveLocaleForApi', 2048)]
readonly class ApiLocaleResolverListener
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function resolveLocaleForApi(): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($this->isApiRequest($request)) {
            $request->setLocale('en');
        }
    }

    private function isApiRequest(Request $request): bool
    {
        return str_starts_with($request->getPathInfo(), '/api');
    }
}

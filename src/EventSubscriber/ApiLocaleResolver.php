<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Translation\LocaleSwitcher;

readonly class ApiLocaleResolver implements EventSubscriberInterface
{
    public function __construct(private RequestStack $requestStack, private LocaleSwitcher $localeSwitcher)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'resolveLocaleForApi',
        ];
    }

    public function resolveLocaleForApi(): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (str_starts_with($request->getPathInfo(), '/api')) {
            $this->localeSwitcher->setLocale('en');
        }
    }
}

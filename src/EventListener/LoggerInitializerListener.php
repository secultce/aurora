<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Log\Log;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(KernelEvents::REQUEST, 'loggerInitializer', 5096)]
readonly class LoggerInitializerListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function loggerInitializer(): void
    {
        Log::init($this->logger);
    }
}

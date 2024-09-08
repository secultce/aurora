<?php

declare(strict_types=1);

namespace App\Log;

use Psr\Log\LoggerInterface;
use RuntimeException;

abstract class Log
{
    private static ?LoggerInterface $logger = null;

    public static function init(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    private static function getLogger(): LoggerInterface
    {
        if (null === self::$logger) {
            throw new RuntimeException('Logger has not been initialized.');
        }

        return self::$logger;
    }

    public static function critical(string $message, array $context = []): void
    {
        self::getLogger()->critical($message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::getLogger()->debug($message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::getLogger()->error($message, $context);
    }

    public static function info(string $message, array $context = []): void
    {
        self::getLogger()->info($message, $context);
    }
}

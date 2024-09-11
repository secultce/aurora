<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

interface TestFixtures
{
    public static function partial(): array;

    public static function complete(): array;
}

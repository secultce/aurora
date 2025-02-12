<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use Symfony\Component\Uid\Uuid;

class TagTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return self::complete();
    }

    public static function complete(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test tag',
        ];
    }
}

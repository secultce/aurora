<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use Symfony\Component\Uid\Uuid;

class UserTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'image' => null,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'image' => ImageTestFixtures::getImageValid(),
        ]);
    }
}

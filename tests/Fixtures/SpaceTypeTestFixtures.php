<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use Symfony\Component\Uid\Uuid;

class SpaceTypeTestFixtures
{
    public static function dataCreate(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test space type',
        ];
    }

    public static function dataUpdate(): array
    {
        return [
            'name' => 'Space type updated',
        ];
    }
}

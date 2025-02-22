<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use Symfony\Component\Uid\Uuid;

class ArchitecturalAccessibilityTestFixtures
{
    public static function dataCreate(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'test architectural accessibility',
            'description' => 'test architectural accessibility description',
        ];
    }

    public static function dataUpdate(): array
    {
        return [
            'name' => 'test architectural accessibility updated',
            'description' => 'test architectural accessibility description updated',
        ];
    }
}

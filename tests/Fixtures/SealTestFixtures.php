<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\AgentFixtures;
use Symfony\Component\Uid\Uuid;

class SealTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test seal',
            'description' => 'Test seal description',
            'active' => true,
            'createdBy' => AgentFixtures::AGENT_ID_2,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'expirationDate' => '2025-12-31',
        ]);
    }
}

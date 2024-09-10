<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\AgentFixtures;
use Symfony\Component\Uid\Uuid;

class OrganizationTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test Organization',
            'owner' => AgentFixtures::AGENT_ID_1,
            'createdBy' => AgentFixtures::AGENT_ID_1,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'description' => 'Test Organization',
            'agents' => [
                AgentFixtures::AGENT_ID_1,
                AgentFixtures::AGENT_ID_2,
                AgentFixtures::AGENT_ID_3,
            ],
        ]);
    }
}

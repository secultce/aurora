<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\OpportunityFixtures;
use Symfony\Component\Uid\Uuid;

class PhaseTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test Phase',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'status' => true,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'description' => 'Test phase description',
            'startDate' => '2024-07-01',
            'endDate' => '2024-08-01',
            'extraFields' => [
                'Teste' => 'Extra fields',
            ],
        ]);
    }
}

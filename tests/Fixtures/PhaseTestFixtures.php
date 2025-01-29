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
            'reviewers' => [AgentFixtures::AGENT_ID_3, AgentFixtures::AGENT_ID_4],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'extraFields' => [
                'Teste' => 'Extra fields',
            ],
        ]);
    }
}

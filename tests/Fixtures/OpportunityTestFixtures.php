<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\EventFixtures;
use App\DataFixtures\Entity\InitiativeFixtures;
use App\DataFixtures\Entity\OpportunityFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use Symfony\Component\Uid\Uuid;

class OpportunityTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test Opportunity',
            'createdBy' => AgentFixtures::AGENT_ID_1,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'parent' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'space' => SpaceFixtures::SPACE_ID_1,
            'initiative' => InitiativeFixtures::INITIATIVE_ID_1,
            'event' => EventFixtures::EVENT_ID_1,
        ]);
    }
}

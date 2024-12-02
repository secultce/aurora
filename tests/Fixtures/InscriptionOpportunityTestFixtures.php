<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\OpportunityFixtures;
use Symfony\Component\Uid\Uuid;

class InscriptionOpportunityTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'agent' => AgentFixtures::AGENT_ID_2,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_10,
            'status' => 'active',
        ];
    }

    public static function complete(): array
    {
        return self::partial();
    }
}

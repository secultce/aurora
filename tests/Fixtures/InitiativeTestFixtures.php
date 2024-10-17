<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\InitiativeFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use Symfony\Component\Uid\Uuid;

class InitiativeTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test initiative',
            'createdBy' => AgentFixtures::AGENT_ID_1,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'space' => SpaceFixtures::SPACE_ID_4,
            'parent' => InitiativeFixtures::INITIATIVE_ID_2,
            'extraFields' => [
                'type' => 'Cultural',
                'description' => 'É uma exposição que reúne artesãos de todo o Brasil para celebrar a cultura nordestina.',
            ],
        ]);
    }
}

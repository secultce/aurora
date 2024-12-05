<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use Symfony\Component\Uid\Uuid;

class SpaceTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test Space',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => SpaceFixtures::SPACE_ID_1,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'extraFields' => [
                'type' => 'Cultural',
                'description' => 'É um espaço cultural que reúne artesãos de todo o Brasil para celebrar a cultura nordestina.',
                'location' => 'Recife, Pernambuco',
                'capacity' => 100,
                'areasOfActivity' => ['Teatro', 'Música', 'Artes Visuais'],
                'accessibility' => ['Banheiros adaptados', 'Rampa de acesso', 'Elevador adaptado', 'Sinalização tátil'],
            ],
        ]);
    }
}

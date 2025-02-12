<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\ActivityAreaFixtures;
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
            'maxCapacity' => 100,
            'isAccessible' => true,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'shortDescription' => 'Test short description',
            'longDescription' => 'Test long description',
            'image' => null,
            'coverImage' => 'test-cover-image.jpg',
            'site' => 'https://test-site.com',
            'email' => 'test@email.com',
            'phoneNumber' => '+55 85 99999-9999',
            'extraFields' => [
                'type' => 'Cultural',
                'description' => 'É um espaço cultural que reúne artesãos de todo o Brasil para celebrar a cultura nordestina.',
                'location' => 'Recife, Pernambuco',
                'capacity' => 100,
                'accessibility' => ['Banheiros adaptados', 'Rampa de acesso', 'Elevador adaptado', 'Sinalização tátil'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
            ],
        ]);
    }
}

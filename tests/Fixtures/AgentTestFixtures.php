<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\OrganizationFixtures;
use Symfony\Component\Uid\Uuid;

class AgentTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test Agent',
            'image' => null,
            'shortBio' => 'Short Bio',
            'longBio' => 'Long Bio',
            'culture' => true,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'image' => ImageTestFixtures::getImageValid(),
            'organizations' => [OrganizationFixtures::ORGANIZATION_ID_1],
        ]);
    }
}

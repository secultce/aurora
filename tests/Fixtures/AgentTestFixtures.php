<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\OrganizationFixtures;
use App\DataFixtures\Entity\UserFixtures;
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
            'user' => UserFixtures::USER_ID_1,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'image' => ImageTestFixtures::getImageValid(),
            'organizations' => [OrganizationFixtures::ORGANIZATION_ID_1],
            'extraFields' => [
                'site' => 'https://www.google.com/',
                'instagram' => '@test.agent',
                'facebook' => '@test.agent',
                'x' => '@test.agent',
            ],
        ]);
    }
}

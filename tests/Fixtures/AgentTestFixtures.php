<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\DataFixtures\Entity\OrganizationFixtures;
use App\DataFixtures\Entity\UserFixtures;
use App\Entity\Agent;
use Symfony\Component\Uid\Uuid;

class AgentTestFixtures implements TestFixtures
{
    public static function partial(): array
    {
        return [
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Test Agent',
            'shortBio' => 'Short Bio',
            'longBio' => 'Long Bio',
            'culture' => true,
            'main' => false,
            'user' => UserFixtures::USER_ID_1,
        ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'organizations' => [OrganizationFixtures::ORGANIZATION_ID_1],
            'extraFields' => [
                'site' => 'https://www.google.com/',
                'instagram' => '@test.agent',
                'facebook' => '@test.agent',
                'x' => '@test.agent',
            ],
        ]);
    }

    public static function objectAgent(): Agent
    {
        $agentData = self::partial();

        $agent = new Agent();
        $agent->setId(Uuid::fromString($agentData['id']));
        $agent->setName($agentData['name']);
        $agent->setShortBio($agentData['shortBio']);
        $agent->setLongBio($agentData['longBio']);
        $agent->setCulture($agentData['culture']);
        $agent->setMain($agentData['main']);

        return $agent;
    }
}

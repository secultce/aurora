<?php

namespace App\Tests\Fixtures;


use App\DataFixtures\Entity\AgentFixtures;
use Symfony\Component\Uid\Uuid;

class AgentAddressTestFixtures implements TestFixtures
{


    public static function partial(): array
    {
       return [
           'id' => Uuid::v4()->toRfc4122(),
           'street' => 'Rua do Limoeiro',
           'number' => '78',
           'neighborhood' => 'Pomar',
           'city' => '86b5db1d-eacc-4227-aaf7-353b397156a4',
           'zipcode' => '60800100',
           'owner' => AgentFixtures::AGENT_ID_3,
           'ownerType' => 'agent',
       ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'complement' => 'Casa 1',
        ]);
    }
}

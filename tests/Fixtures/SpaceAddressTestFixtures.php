<?php

namespace App\Tests\Fixtures;


use App\DataFixtures\Entity\SpaceFixtures;
use Symfony\Component\Uid\Uuid;

class SpaceAddressTestFixtures implements TestFixtures
{


    public static function partial(): array
    {
       return [
           'id' => Uuid::v4()->toRfc4122(),
           'street' => 'Rua Romero Salgado',
           'number' => '554',
           'neighborhood' => 'Jurema',
           'city' => '86b5db1d-eacc-4227-aaf7-353b397156a4',
           'zipcode' => '62195002',
           'owner' => SpaceFixtures::SPACE_ID_2,
           'ownerType' => 'space',
       ];
    }

    public static function complete(): array
    {
        return array_merge(self::partial(), [
            'complement' => 'Apt 133',
        ]);
    }
}

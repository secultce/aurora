<?php

namespace App\DataFixtures\Entity;

use App\Entity\Address;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends AbstractFixture
{
    public const string ADDRESS_ID_PREFIX = 'address';
    public const string ADDRESS_ID_1 = 'b1b3eddd-3eac-4d96-97b5-1662767ae5f6';
    public const string ADDRESS_ID_2 = 'b8636a9e-3906-4751-b4a9-7a24995813aa';
    public const string ADDRESS_ID_3 = '425bdb7a-1ea2-41b5-bcb8-3511ef8f750a';
    public const string ADDRESS_ID_4 = 'fd64752a-c7ed-44ff-b092-44076dea4b4c';
    public const string ADDRESS_ID_5 = 'c4469910-ddd8-4dff-93dc-7ae5d9dc9ccc';
    public const string ADDRESS_ID_6 = 'eb8fe1b6-612b-4ad8-99c3-b40db0fb1bf4';
    public const string ADDRESS_ID_7 = '53cd0cdf-535b-4f66-90ed-ba6319ee67c6';
    public const string ADDRESS_ID_8 = '479b58bd-8764-4bcb-bcd3-200c66c6f4f6';
    public const string ADDRESS_ID_9 = '0ef8757b-1f72-4a94-8f77-07f4e5027b58';
    public const string ADDRESS_ID_10 = '4e0c4523-5dd3-4e0b-ba71-fc16cfdf9afa';

    public const array ADDRESSES = [
        [
            'id' => self::ADDRESS_ID_1,
            'street' => 'Rue de la Paix',
            'number' => '64',
            'neighbourhood' => '',
            'zipCode' => '75000000',
            'city' => '',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $this->truncateTable(Address::class);
        $this->createAddresses($manager);
    }

    private function createAddresses(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $address = new Address();
            $address->setStreet($this->faker->streetAddress);
            $address->setCity($this->faker->city);
            $address->setZipCode($this->faker->postcode);
            $address->setCountry($this->faker->country);
            $manager->persist($address);
        }
        $manager->flush();
    }
}
<?php

namespace App\DataFixtures\Entity;

use App\Entity\Address;
use App\Entity\Agent;
use App\Entity\AgentAddress;
use App\Entity\City;
use App\Entity\Space;
use App\Entity\SpaceAddress;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class AddressFixtures extends AbstractFixture implements DependentFixtureInterface
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
            'complement' => 'Qt 18',
            'neighborhood' => 'Ventos',
            'zipCode' => '75000000',
            'city' => 'faa1ef21-6b4f-409b-bd64-6110e920ba12',
            'owner' => AgentFixtures::AGENT_ID_1,
            'ownerType' => 'agent',
        ],
        [
            'id' => self::ADDRESS_ID_2,
            'street' => 'Avenida das Oliveiras',
            'number' => 'S/N',
            'neighborhood' => 'Jardins',
            'zipCode' => '60300100',
            'city' => '7e105534-8232-41ae-a7c8-8179c97049db',
            'owner' => SpaceFixtures::SPACE_ID_2,
            'ownerType' => 'space',
        ],
        [
            'id' => self::ADDRESS_ID_3,
            'street' => 'Rua das Flores',
            'number' => '123',
            'complement' => 'Bloco A',
            'neighborhood' => 'Primavera',
            'zipCode' => '01002000',
            'city' => '723454ca-5510-4837-9da9-123f7eeaf993',
            'owner' => AgentFixtures::AGENT_ID_3,
            'ownerType' => 'agent',
        ],
        [
            'id' => self::ADDRESS_ID_4,
            'street' => 'Avenida Central',
            'number' => '456',
            'complement' => 'Sala 302',
            'neighborhood' => 'Centro',
            'zipCode' => '20231000',
            'city' => '1c32eb00-8bbb-4dea-a6fc-6e7e1eeca0c0',
            'owner' => SpaceFixtures::SPACE_ID_4,
            'ownerType' => 'space',
        ],
        [
            'id' => self::ADDRESS_ID_5,
            'street' => 'Travessa do Sol',
            'number' => '7',
            'complement' => null,
            'neighborhood' => 'Aurora',
            'zipCode' => '30330110',
            'city' => '4fb2b7ee-1b87-4af4-8ece-ce77488d4bc5',
            'owner' => AgentFixtures::AGENT_ID_5,
            'ownerType' => 'agent',
        ],
        [
            'id' => self::ADDRESS_ID_6,
            'street' => 'Estrada Verde',
            'number' => 'KM 23',
            'complement' => null,
            'neighborhood' => 'Floresta',
            'zipCode' => '40440220',
            'city' => '7a1a5fb8-a75f-4640-939f-2c208a6ebc68',
            'owner' => SpaceFixtures::SPACE_ID_6,
            'ownerType' => 'space',
        ],
        [
            'id' => self::ADDRESS_ID_7,
            'street' => 'Praça das Nações',
            'number' => '22',
            'complement' => 'Casa 2',
            'neighborhood' => 'Mundo Novo',
            'zipCode' => '50550550',
            'city' => '0258f327-0499-4531-ba4f-1ca1f5f817b6',
            'owner' => AgentFixtures::AGENT_ID_7,
            'ownerType' => 'agent',
        ],
        [
            'id' => self::ADDRESS_ID_8,
            'street' => 'Rua dos Pinheiros',
            'number' => '18',
            'complement' => 'Cobertura',
            'neighborhood' => 'Horizonte',
            'zipCode' => '60660660',
            'city' => '06d4247c-fc11-429a-ad61-cfabda912671',
            'owner' => SpaceFixtures::SPACE_ID_8,
            'ownerType' => 'space',
        ],
        [
            'id' => self::ADDRESS_ID_9,
            'street' => 'Avenida Atlântica',
            'number' => '1000',
            'complement' => null,
            'neighborhood' => 'Beira-Mar',
            'zipCode' => '70770770',
            'city' => 'ca0e63bc-292c-4a53-b691-90745f5cbcbb',
            'owner' => AgentFixtures::AGENT_ID_9,
            'ownerType' => 'agent',
        ],
        [
            'id' => self::ADDRESS_ID_10,
            'street' => 'Largo do Pôr do Sol',
            'number' => '55',
            'complement' => 'Ap 101',
            'neighborhood' => 'Crepúsculo',
            'zipCode' => '80880880',
            'city' => '20fdb45a-e395-44b3-9b68-6c8540080d34',
            'owner' => SpaceFixtures::SPACE_ID_8,
            'ownerType' => 'space',
        ],
    ];

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->truncateTable(Address::class);
        $this->createAddresses($manager);

    }

    private function createAddresses(ObjectManager $manager): void
    {
        foreach (self::ADDRESSES as $addressData) {
            if ($addressData['ownerType'] === 'agent') {
                $address = new AgentAddress();
                $address->owner = $manager->getRepository(Agent::class)->find($addressData['owner']);
            } else if ($addressData['ownerType'] === 'space') {
                $address = new SpaceAddress();
                $address->owner = $manager->getRepository(Space::class)->find($addressData['owner']);
            }

            $address->setId(Uuid::fromString($addressData['id']));
            $address->setStreet($addressData['street']);
            $address->setNumber($addressData['number']);
            $address->setComplement($addressData['complement'] ?? null);
            $address->setNeighborhood($addressData['neighborhood']);
            $address->setZipCode($addressData['zipCode']);
            $address->setCity($manager->getRepository(City::class)->find($addressData['city']));
            $manager->persist($address);
            $this->addReference($addressData['id'], $address);
        }
        $manager->flush();
    }
}

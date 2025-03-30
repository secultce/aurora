<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\Address;
use App\Entity\AgentAddress;
use App\Entity\City;
use App\Entity\SpaceAddress;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

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

    public const array UPDATED_ADDRESSES = [
        [
            'id' => self::ADDRESS_ID_1,
            'street' => 'Rua da Paz',
            'number' => '64',
            'complement' => 'Ap 14',
            'neighborhood' => 'Ventos',
            'zipCode' => '63600000',
            'city' => 'faa1ef21-6b4f-409b-bd64-6110e920ba12',
            'owner' => AgentFixtures::AGENT_ID_1,
            'ownerType' => 'agent',
        ],
        [
            'id' => self::ADDRESS_ID_4,
            'street' => 'Avenida Central',
            'number' => '456',
            'complement' => 'Sala 302',
            'neighborhood' => 'Centro',
            'zipCode' => '30003210',
            'city' => '917b34dc-4d5b-4d95-bfe3-9b71b1009c16',
            'owner' => SpaceFixtures::SPACE_ID_4,
            'ownerType' => 'space',
        ],
    ];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TokenStorageInterface $tokenStorage,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct($entityManager, $tokenStorage);
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
            SpaceFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createAddresses($manager);
        $this->updateAddresses($manager);
    }

    private function createAddresses(ObjectManager $manager): void
    {
        foreach (self::ADDRESSES as $addressData) {
            $address = $this->mountAddress($addressData);

            $this->addReference(sprintf('%s-%s', self::ADDRESS_ID_PREFIX, $addressData['id']), $address);

            $manager->persist($address);
        }

        $manager->flush();
    }

    private function updateAddresses(ObjectManager $manager): void
    {
        foreach (self::UPDATED_ADDRESSES as $addressData) {
            $className = match ($addressData['ownerType']) {
                'agent' => AgentAddress::class,
                'space' => SpaceAddress::class,
            };

            $addressObj = $this->getReference(sprintf('%s-%s', self::ADDRESS_ID_PREFIX, $addressData['id']), $className);
            $address = $this->mountAddress($addressData, ['object_to_populate' => $addressObj]);

            $manager->persist($address);
        }

        $manager->flush();
    }

    public function mountAddress(array $addressData, array $context = []): Address
    {
        $address = $this->serializer->denormalize($addressData, Address::class, context: $context);
        $address->setCity($this->entityManager->getRepository(City::class)->find($addressData['city']));

        return $address;
    }
}

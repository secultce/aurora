<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\SpaceType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class SpaceTypeFixtures extends AbstractFixture
{
    public const string SPACE_TYPE_ID_PREFIX = 'space-type';
    public const string SPACE_TYPE_ID_1 = '4c1b60cf-737e-408d-b26b-3ded333d3c2c';
    public const string SPACE_TYPE_ID_2 = 'bbe3312d-ccf5-4df3-b341-e43d4396ab15';
    public const string SPACE_TYPE_ID_3 = 'f88d9b12-34c5-45a7-8a7f-2e34d1a8c9b6';

    public const array SPACE_TYPES = [
        [
            'id' => self::SPACE_TYPE_ID_1,
            'name' => 'Laboratório',
        ],
        [
            'id' => self::SPACE_TYPE_ID_2,
            'name' => 'Casa de Show',
        ],
        [
            'id' => self::SPACE_TYPE_ID_3,
            'name' => 'Teatro',
        ],
    ];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TokenStorageInterface $tokenStorage,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct($entityManager, $tokenStorage);
    }

    public function load(ObjectManager $manager): void
    {
        $this->truncateTable(SpaceType::class);
        $this->createSpaceTypes($manager);
        $this->manualLogout();
    }

    private function createSpaceTypes(ObjectManager $manager): void
    {
        foreach (self::SPACE_TYPES as $spaceTypeData) {
            $spaceType = $this->serializer->denormalize($spaceTypeData, SpaceType::class);

            $this->setReference(sprintf('%s-%s', self::SPACE_TYPE_ID_PREFIX, $spaceTypeData['id']), $spaceType);

            $manager->persist($spaceType);
        }
        $manager->flush();
    }
}

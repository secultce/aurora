<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Space;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

final class SpaceFixtures extends Fixture
{
    public const string SPACE_ID_PREFIX = 'space';
    public const string SPACE_ID_1 = '69461af3-52f2-4c6b-ad30-ce92e478e9bd';
    public const string SPACE_ID_2 = 'ae32b8a5-25a8-4b80-b415-4237a8484186';
    public const string SPACE_ID_3 = '608756eb-4830-49f2-ae14-1160ca5252f4';
    public const string SPACE_ID_4 = '25dc221a-f4a6-4e40-94c3-73b1d553f2c1';
    public const string SPACE_ID_5 = '46137ea7-6ca9-4782-b940-b45c74716a4f';
    public const string SPACE_ID_6 = 'a54d5bc6-0748-4554-aaf9-80cad467f991';
    public const string SPACE_ID_7 = 'd53c4e9b-b72c-4b22-b18d-be8f404cd242';
    public const string SPACE_ID_8 = '86071ac5-021c-4e44-a200-7159fe57a810';
    public const string SPACE_ID_9 = 'eaf6a58d-ff9b-4446-8e1a-9bb9164adc74';
    public const string SPACE_ID_10 = 'b4a49f4d-25ca-40f9-bac2-e72383b689ed';

    public const array SPACES = [
        [
            'id' => self::SPACE_ID_1,
            'name' => 'SECULT',
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_2,
            'name' => 'Sítio das Artes',
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_3,
            'name' => 'Ritmos do Mundo',
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_4,
            'name' => 'Recanto do Cordel',
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_5,
            'name' => 'Galeria Caatinga',
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_6,
            'name' => 'Casa do Sertão',
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_7,
            'name' => 'Vila do Baião',
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_8,
            'name' => 'Centro Cultural Asa Branca',
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_9,
            'name' => 'Casa da Capoeira',
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_10,
            'name' => 'Dragão do Mar',
            'createdAt' => '2024-08-14T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::SPACES as $spaceData) {
            /* @var Space $space */
            $space = $this->serializer->denormalize($spaceData, Space::class);

            $this->setReference(sprintf('%s-%s', self::SPACE_ID_PREFIX, $spaceData['id']), $space);

            $manager->persist($space);
        }

        $manager->flush();
    }
}

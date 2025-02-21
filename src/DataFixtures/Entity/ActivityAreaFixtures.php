<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\ActivityArea;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ActivityAreaFixtures extends AbstractFixture
{
    public const string ACTIVITY_AREA_ID_PREFIX = 'activity_area';
    public const string ACTIVITY_AREA_ID_1 = 'a1b2c3d4-e5f6-7890-1234-56789abcdef0';
    public const string ACTIVITY_AREA_ID_2 = 'b2c3d4e5-f678-9012-3456-789abcdef012';
    public const string ACTIVITY_AREA_ID_3 = 'c3d4e5f6-7890-1234-5678-9abcdef01234';
    public const string ACTIVITY_AREA_ID_4 = 'd4e5f678-9012-3456-789a-bcdef0123456';
    public const string ACTIVITY_AREA_ID_5 = 'e5f67890-1234-5678-9abc-def012345678';
    public const string ACTIVITY_AREA_ID_6 = 'f6789012-3456-789a-bcde-f01234567890';
    public const string ACTIVITY_AREA_ID_7 = '67890123-4567-89ab-cdef-012345678901';
    public const string ACTIVITY_AREA_ID_8 = '78901234-5678-9abc-def0-123456789012';
    public const string ACTIVITY_AREA_ID_9 = '89012345-6789-abcd-ef01-234567890123';
    public const string ACTIVITY_AREA_ID_10 = '90123456-789a-bcde-f012-345678901234';

    public const array ACTIVITY_AREAS = [
        [
            'id' => self::ACTIVITY_AREA_ID_1,
            'name' => 'Artes Visuais',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_2,
            'name' => 'Música',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_3,
            'name' => 'Teatro',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_4,
            'name' => 'Dança',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_5,
            'name' => 'Cinema',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_6,
            'name' => 'Literatura',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_7,
            'name' => 'Gastronomia',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_8,
            'name' => 'Design',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_9,
            'name' => 'Artesanato',
        ],
        [
            'id' => self::ACTIVITY_AREA_ID_10,
            'name' => 'Fotografia',
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
        $this->createActivityAreas($manager);
    }

    private function createActivityAreas(ObjectManager $manager): void
    {
        foreach (self::ACTIVITY_AREAS as $activityAreaData) {
            $activityArea = $this->serializer->denormalize($activityAreaData, ActivityArea::class);

            $this->setReference(sprintf('%s-%s', self::ACTIVITY_AREA_ID_PREFIX, $activityAreaData['id']), $activityArea);

            $manager->persist($activityArea);
        }

        $manager->flush();
    }
}

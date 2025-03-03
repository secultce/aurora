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
    public const string ACTIVITY_AREA_ID_1 = '3b90f7c7-5105-4727-b223-b4471139d153';
    public const string ACTIVITY_AREA_ID_2 = '7e76954d-d9e2-4e5c-867f-dbf2cff763af';
    public const string ACTIVITY_AREA_ID_3 = '857937f7-2b75-46e2-9e22-e24e120214c1';
    public const string ACTIVITY_AREA_ID_4 = 'e691ee02-fa5b-4da9-9db3-b5beeec5ee3a';
    public const string ACTIVITY_AREA_ID_5 = 'b8b715fe-d9e9-4231-8257-ff1944d220d0';
    public const string ACTIVITY_AREA_ID_6 = 'b1068e28-91e0-4847-8dfd-14bcc23c0a8f';
    public const string ACTIVITY_AREA_ID_7 = 'e14008c9-cb10-4bd9-b9a2-bc5285993b85';
    public const string ACTIVITY_AREA_ID_8 = '3a4036d8-e283-446d-8402-017af0a33ce7';
    public const string ACTIVITY_AREA_ID_9 = '4787ac47-492d-4ce3-b46d-f72713212493';
    public const string ACTIVITY_AREA_ID_10 = 'd72e117e-a1cd-4a88-8656-5bf37a7296f8';

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

<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class TagFixtures extends AbstractFixture
{
    public const string TAG_ID_PREFIX = 'tag';
    public const string TAG_ID_1 = '100ec80e-59be-420e-82d7-0e7914923499';
    public const string TAG_ID_2 = 'ebdb9655-ee51-4e29-958a-8bcda77f7185';
    public const string TAG_ID_3 = '22ccd7d5-8528-4d8b-8356-4706d9a96117';
    public const string TAG_ID_4 = 'd9285a47-57bf-4be8-84c6-0c33421bd09b';
    public const string TAG_ID_5 = 'd9ad0ca8-772b-4e7d-98ff-8bc28d4d4aa2';
    public const string TAG_ID_6 = '56ff62e0-2138-4d41-abf3-337d09fa9c1d';
    public const string TAG_ID_7 = '457f3d86-b253-4867-a734-e0c7efa72c0c';
    public const string TAG_ID_8 = '1a091b68-c87f-4094-9d79-cb50bc39e6e0';
    public const string TAG_ID_9 = '93255059-add9-415b-b15e-42201127592d';
    public const string TAG_ID_10 = '364a7661-981d-4bfd-b26c-be919b9ac67e';

    public const array TAGS = [
        [
            'id' => self::TAG_ID_1,
            'name' => 'Cultura',
        ],
        [
            'id' => self::TAG_ID_2,
            'name' => 'Tecnologia',
        ],
        [
            'id' => self::TAG_ID_3,
            'name' => 'Sustentabilidade',
        ],
        [
            'id' => self::TAG_ID_4,
            'name' => 'Social',
        ],
        [
            'id' => self::TAG_ID_5,
            'name' => 'Educação',
        ],
        [
            'id' => self::TAG_ID_6,
            'name' => 'Tradição',
        ],
        [
            'id' => self::TAG_ID_7,
            'name' => 'Juventude',
        ],
        [
            'id' => self::TAG_ID_8,
            'name' => 'Oficina',
        ],
        [
            'id' => self::TAG_ID_9,
            'name' => 'Regional',
        ],
        [
            'id' => self::TAG_ID_10,
            'name' => 'Show',
        ],
    ];

    public const array TAGS_UPDATED = [
        [
            'id' => self::TAG_ID_10,
            'name' => 'Feira',
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
        $this->createTags($manager);
        $this->updateTags($manager);
        $this->manualLogout();
    }

    private function createTags(ObjectManager $manager): void
    {
        foreach (self::TAGS as $tagData) {
            $tag = $this->serializer->denormalize($tagData, Tag::class);

            $this->setReference(sprintf('%s-%s', self::TAG_ID_PREFIX, $tagData['id']), $tag);

            $manager->persist($tag);
        }

        $manager->flush();
    }

    private function updateTags(ObjectManager $manager): void
    {
        foreach (self::TAGS_UPDATED as $tagData) {
            $tagObj = $this->getReference(sprintf('%s-%s', self::TAG_ID_PREFIX, $tagData['id']), Tag::class);

            $tag = $this->serializer->denormalize($tagData, Tag::class, context: ['object_to_populate' => $tagObj]);

            $manager->persist($tag);
        }

        $manager->flush();
    }
}

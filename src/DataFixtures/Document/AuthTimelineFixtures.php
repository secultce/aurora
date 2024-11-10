<?php

declare(strict_types=1);

namespace App\DataFixtures\Document;

use App\DataFixtures\Entity\UserFixtures;
use App\Document\AuthTimeline;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class AuthTimelineFixtures extends Fixture
{
    public const array DOCUMENTS = [
        [
            'id' => '66eb140719186a653156db25',
            'userId' => UserFixtures::USER_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'linux',
            'action' => 'api',
        ],
        [
            'id' => '66eb140519186a653156db1c',
            'userId' => UserFixtures::USER_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'linux',
            'action' => 'api',
        ],
        [
            'id' => '66eb140519186a653156db1d',
            'userId' => UserFixtures::USER_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'linux',
            'action' => 'api',
        ],
        [
            'id' => '66eb140519186a653156db1e',
            'userId' => UserFixtures::USER_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'linux',
            'action' => 'api',
        ],
        [
            'id' => '66eb140619186a653156db1f',
            'userId' => UserFixtures::USER_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'linux',
            'action' => 'api',
        ],
    ];

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::DOCUMENTS as $data) {
            $documentData = [
                'id' => $data['id'],
                'userId' => $data['id'],
                'resourceId' => $data['id'],
                'priority' => 1,
                'datetime' => $data['createdAt'],
                'device' => 'linux',
                'platform' => 'api',
                'action' => 'api',
            ];

            /** @var AuthTimeline $document */
            $document = $this->serializer->denormalize($documentData, AuthTimeline::class);
            $manager->persist($document);
        }

        $manager->flush();
    }
}

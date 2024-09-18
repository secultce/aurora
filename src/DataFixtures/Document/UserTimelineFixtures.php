<?php

declare(strict_types=1);

namespace App\DataFixtures\Document;

use App\DataFixtures\Entity\UserFixtures;
use App\Document\UserTimeline;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class UserTimelineFixtures extends Fixture
{
    public const array IDS = [
        '66e88015e5601d427b9ecf9f' => UserFixtures::USERS[0],
        '66e8800ae5601d427b9ecf95' => UserFixtures::USERS[1],
        '66e8800ae5601d427b9ecf96' => UserFixtures::USERS[2],
        '66e8800be5601d427b9ecf98' => UserFixtures::USERS[3],
        '66e8800be5601d427b9ecf99' => UserFixtures::USERS[4],
        '66e88014e5601d427b9ecf9a' => UserFixtures::USERS[5],
        '66e88014e5601d427b9ecf9b' => UserFixtures::USERS[6],
        '66e88014e5601d427b9ecf9c' => UserFixtures::USERS[7],
        '66e88015e5601d427b9ecf9d' => UserFixtures::USERS[8],
        '66e88015e5601d427b9ecf9e' => UserFixtures::USERS[9],
    ];

    public const array DOCUMENT_UPDATED = [
        [
            'id' => '66e88767e5601d427b9ecfa0',
            'userId' => UserFixtures::USER_ID_1,
            'resourceId' => UserFixtures::USER_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [
                'id' => UserFixtures::USER_ID_1,
                'firstname' => 'Francisco',
                'lastname' => ' Alessandro Feitosa',
                'socialName' => 'Alessandro Feitosa',
                'email' => 'alessandrofeitoza@example.com',
                'password' => 'feitoza',
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'to' => [
                'id' => UserFixtures::USER_ID_1,
                'firstname' => 'Francisco',
                'lastname' => ' Alessandro Feitoza',
                'socialName' => 'Alessandro Feitoza',
                'email' => 'alessandrofeitoza@example.com',
                'password' => 'feitoza',
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T11:35:00+00:00',
                'deletedAt' => null,
            ],
        ],
    ];

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::IDS as $key => $userData) {
            $documentData = [
                'id' => $key,
                'userId' => $userData['id'],
                'resourceId' => $userData['id'],
                'priority' => 1,
                'datetime' => $userData['createdAt'],
                'device' => 'linux',
                'platform' => 'api',
                'from' => [],
                'to' => $userData,
            ];

            /* @var UserTimeline $object */
            $document = $this->serializer->denormalize($documentData, UserTimeline::class);
            $manager->persist($document);
        }

        foreach (self::DOCUMENT_UPDATED as $documentData) {
            /* @var UserTimeline $object */
            $document = $this->serializer->denormalize($documentData, UserTimeline::class);
            $manager->persist($document);
        }

        $manager->flush();
    }
}

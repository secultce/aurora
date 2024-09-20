<?php

declare(strict_types=1);

namespace App\DataFixtures\Document;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\InitiativeFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\Document\InitiativeTimeline;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class InitiativeTimelineFixtures extends Fixture
{
    public const IDS = [
        '66ecc7c2af232d0605ac53ef' => InitiativeFixtures::INITIATIVES[0],
        '66ecc7c0af232d0605ac53e6' => InitiativeFixtures::INITIATIVES[1],
        '66ecc7c1af232d0605ac53e7' => InitiativeFixtures::INITIATIVES[2],
        '66ecc7c1af232d0605ac53e8' => InitiativeFixtures::INITIATIVES[3],
        '66ecc7c1af232d0605ac53e9' => InitiativeFixtures::INITIATIVES[4],
        '66ecc7c1af232d0605ac53ea' => InitiativeFixtures::INITIATIVES[5],
        '66ecc7c1af232d0605ac53eb' => InitiativeFixtures::INITIATIVES[6],
        '66ecc7c2af232d0605ac53ec' => InitiativeFixtures::INITIATIVES[7],
        '66ecc7c2af232d0605ac53ed' => InitiativeFixtures::INITIATIVES[8],
        '66ecc7c2af232d0605ac53ee' => InitiativeFixtures::INITIATIVES[9],
    ];

    public const DOCUMENT_UPDATED = [
        [
            'id' => '66eccae6af232d0605ac53f0',
            'userId' => AgentFixtures::AGENT_ID_1,
            'resourceId' => InitiativeFixtures::INITIATIVE_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [],
            'to' => [
                'id' => InitiativeFixtures::INITIATIVE_ID_1,
                'name' => 'Cantores do Sertão',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'parent' => null,
                'space' => SpaceFixtures::SPACE_ID_3,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
        ],
        [
            'id' => '66eccae6af232d0605ac53f1',
            'userId' => AgentFixtures::AGENT_ID_1,
            'resourceId' => InitiativeFixtures::INITIATIVE_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [
                'id' => InitiativeFixtures::INITIATIVE_ID_1,
                'name' => 'Cantores do Sertão',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'parent' => null,
                'space' => SpaceFixtures::SPACE_ID_3,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'to' => [
                'id' => InitiativeFixtures::INITIATIVE_ID_1,
                'name' => 'Vozes do Sertão',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'parent' => null,
                'space' => SpaceFixtures::SPACE_ID_4,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
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
        foreach (self::IDS as $key => $initiativeData) {
            $documentData = [
                'id' => $key,
                'userId' => $initiativeData['createdBy'],
                'resourceId' => $initiativeData['id'],
                'priority' => 1,
                'datetime' => $initiativeData['createdAt'],
                'device' => 'linux',
                'platform' => 'api',
                'from' => [],
                'to' => $initiativeData,
            ];

            /** @var InitiativeTimeline $document */
            $document = $this->serializer->denormalize($documentData, InitiativeTimeline::class);
            $manager->persist($document);
        }

        foreach (self::DOCUMENT_UPDATED as $documentData) {
            /** @var InitiativeTimeline $document */
            $document = $this->serializer->denormalize($documentData, InitiativeTimeline::class);
            $manager->persist($document);
        }

        $manager->flush();
    }
}

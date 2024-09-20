<?php

declare(strict_types=1);

namespace App\DataFixtures\Document;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\EventFixtures;
use App\DataFixtures\Entity\InitiativeFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\DataFixtures\Entity\UserFixtures;
use App\Document\EventTimeline;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class EventTimelineFixtures extends Fixture
{
    public const array IDS = [
        '66eb11cb19186a653156db0d' => EventFixtures::EVENTS[0],
        '66eb11cb19186a653156db0e' => EventFixtures::EVENTS[1],
        '66eb11cb19186a653156db0f' => EventFixtures::EVENTS[2],
        '66eb11cb19186a653156db10' => EventFixtures::EVENTS[3],
        '66eb11cc19186a653156db11' => EventFixtures::EVENTS[4],
        '66eb11cc19186a653156db12' => EventFixtures::EVENTS[5],
        '66eb11cc19186a653156db13' => EventFixtures::EVENTS[6],
        '66eb11cd19186a653156db14' => EventFixtures::EVENTS[7],
        '66eb11cd19186a653156db15' => EventFixtures::EVENTS[8],
        '66eb11cd19186a653156db16' => EventFixtures::EVENTS[9],
    ];

    public const array DOCUMENT_UPDATED = [
        [
            'id' => '66eb11ce19186a653156db17',
            'userId' => UserFixtures::USER_ID_1,
            'resourceId' => EventFixtures::EVENT_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T11:35:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [
                'id' => EventFixtures::EVENT_ID_1,
                'name' => 'Festival Sertão Criativo',
                'agentGroup' => null,
                'space' => SpaceFixtures::SPACE_ID_3,
                'initiative' => InitiativeFixtures::INITIATIVE_ID_2,
                'parent' => null,
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'to' => [
                'id' => EventFixtures::EVENT_ID_1,
                'name' => 'Festival Sertão Criativo',
                'agentGroup' => null,
                'space' => SpaceFixtures::SPACE_ID_3,
                'initiative' => InitiativeFixtures::INITIATIVE_ID_2,
                'parent' => null,
                'createdBy' => AgentFixtures::AGENT_ID_1,
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

            /* @var EventTimeline $document */
            $document = $this->serializer->denormalize($documentData, EventTimeline::class);
            $manager->persist($document);
        }

        foreach (self::DOCUMENT_UPDATED as $documentData) {
            /* @var EventTimeline $document */
            $document = $this->serializer->denormalize($documentData, EventTimeline::class);
            $manager->persist($document);
        }

        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures\Document;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\UserFixtures;
use App\Document\AgentTimeline;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class AgentTimelineFixtures extends Fixture
{
    public const array IDS = [
        '66eb140419186a653156db1b' => UserFixtures::USERS[0],
        '66eb140519186a653156db1c' => UserFixtures::USERS[1],
        '66eb140519186a653156db1d' => UserFixtures::USERS[2],
        '66eb140519186a653156db1e' => UserFixtures::USERS[3],
        '66eb140619186a653156db1f' => UserFixtures::USERS[4],
        '66eb140619186a653156db20' => UserFixtures::USERS[5],
        '66eb140619186a653156db21' => UserFixtures::USERS[6],
        '66eb140719186a653156db22' => UserFixtures::USERS[7],
        '66eb140719186a653156db23' => UserFixtures::USERS[8],
        '66eb140719186a653156db24' => UserFixtures::USERS[9],
    ];

    public const array DOCUMENT_UPDATED = [
        [
            'id' => '66eb140719186a653156db25',
            'userId' => UserFixtures::USER_ID_1,
            'resourceId' => AgentFixtures::AGENT_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [
                'id' => AgentFixtures::AGENT_ID_1,
                'name' => 'Francisco',
                'shortBio' => 'Desenvolvedor e evangelista de Software',
                'longBio' => 'Fomentador da comunidade de desenvolvimento, um dos fundadores da maior comunidade de PHP do Ceará (PHP com Rapadura)',
                'culture' => false,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'to' => [
                'id' => AgentFixtures::AGENT_ID_1,
                'name' => 'Alessandro',
                'shortBio' => 'Desenvolvedor e evangelista de Software',
                'longBio' => 'Fomentador da comunidade de desenvolvimento, um dos fundadores da maior comunidade de PHP do Ceará (PHP com Rapadura)',
                'culture' => false,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T11:37:00+00:00',
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
        foreach (self::IDS as $key => $agentData) {
            $documentData = [
                'id' => $key,
                'userId' => $agentData['id'],
                'resourceId' => $agentData['id'],
                'priority' => 1,
                'datetime' => $agentData['createdAt'],
                'device' => 'linux',
                'platform' => 'api',
                'from' => [],
                'to' => $agentData,
            ];

            /* @var AgentTimeline $document */
            $document = $this->serializer->denormalize($documentData, AgentTimeline::class);
            $manager->persist($document);
        }

        foreach (self::DOCUMENT_UPDATED as $documentData) {
            /* @var AgentTimeline $document */
            $document = $this->serializer->denormalize($documentData, AgentTimeline::class);
            $manager->persist($document);
        }

        $manager->flush();
    }
}

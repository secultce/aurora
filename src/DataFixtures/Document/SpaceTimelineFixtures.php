<?php

declare(strict_types=1);

namespace App\DataFixtures\Document;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\Document\SpaceTimeline;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class SpaceTimelineFixtures extends Fixture
{
    public const array IDS = [
        '66ecc23eaf232d0605ac53c8' => SpaceFixtures::SPACES[0],
        '66ecc23eaf232d0605ac53c9' => SpaceFixtures::SPACES[1],
        '66ecc23eaf232d0605ac53ca' => SpaceFixtures::SPACES[2],
        '66ecc23eaf232d0605ac53cb' => SpaceFixtures::SPACES[3],
        '66ecc23faf232d0605ac53cc' => SpaceFixtures::SPACES[4],
        '66ecc23faf232d0605ac53cd' => SpaceFixtures::SPACES[5],
        '66ecc23faf232d0605ac53ce' => SpaceFixtures::SPACES[6],
        '66ecc23faf232d0605ac53cf' => SpaceFixtures::SPACES[7],
        '66ecc240af232d0605ac53d0' => SpaceFixtures::SPACES[8],
        '66ecc240af232d0605ac53d1' => SpaceFixtures::SPACES[9],
    ];

    public const array DOCUMENT_UPDATED = [
        [
            'id' => '66ecc35aaf232d0605ac53d9',
            'userId' => AgentFixtures::AGENT_ID_1,
            'resourceId' => SpaceFixtures::SPACE_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [],
            'to' => [
                'id' => SpaceFixtures::SPACE_ID_1,
                'name' => 'Secretaria de Cultura do Estado do Ceará',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'parent' => null,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
        ],
        [
            'id' => '66ecc35aaf232d0605ac53da',
            'userId' => AgentFixtures::AGENT_ID_1,
            'resourceId' => SpaceFixtures::SPACE_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [
                'id' => SpaceFixtures::SPACE_ID_1,
                'name' => 'Secretaria de Cultura do Estado do Ceará',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'parent' => null,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'to' => [
                'id' => SpaceFixtures::SPACE_ID_1,
                'name' => 'SECULT',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'parent' => null,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
                'deletedAt' => null,
            ],
        ],
    ];

    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::IDS as $key => $spaceData) {
            $documentData = [
                'id' => $key,
                'userId' => $spaceData['createdBy'],
                'resourceId' => $spaceData['id'],
                'priority' => 1,
                'datetime' => $spaceData['createdAt'],
                'device' => 'linux',
                'platform' => 'api',
                'from' => [],
                'to' => $spaceData,
            ];

            /* @var SpaceTimeline $document */
            $document = $this->serializer->denormalize($documentData, SpaceTimeline::class);
            $manager->persist($document);
        }

        foreach (self::DOCUMENT_UPDATED as $documentData) {
            /* @var SpaceTimeline $document */
            $document = $this->serializer->denormalize($documentData, SpaceTimeline::class);
            $manager->persist($document);
        }

        $manager->flush();
    }
}

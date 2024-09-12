<?php

declare(strict_types=1);

namespace App\DataFixtures\Document;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\OrganizationFixtures;
use App\Document\OrganizationTimeline;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class OrganizationTimelineFixtures extends Fixture
{
    public const array IDS = [
        '66e1dcfbc2a68f1d556f52b8' => OrganizationFixtures::ITEMS[1],
        '66e1dcfcc2a68f1d556f52b9' => OrganizationFixtures::ITEMS[2],
        '66e1dcfcc2a68f1d556f52ba' => OrganizationFixtures::ITEMS[3],
        '66e1dcfcc2a68f1d556f52bb' => OrganizationFixtures::ITEMS[4],
        '66e1dcfcc2a68f1d556f52bc' => OrganizationFixtures::ITEMS[5],
        '66e1dcfdc2a68f1d556f52bd' => OrganizationFixtures::ITEMS[6],
        '66e1dcfdc2a68f1d556f52be' => OrganizationFixtures::ITEMS[7],
        '66e1dcfdc2a68f1d556f52bf' => OrganizationFixtures::ITEMS[8],
        '66e1dcfdc2a68f1d556f52c0' => OrganizationFixtures::ITEMS[9],
    ];

    public const array DOCUMENT_UPDATED = [
        [
            'id' => '66e1bc11c8af7c98000698f2',
            'userId' => AgentFixtures::AGENT_ID_1,
            'resourceId' => OrganizationFixtures::ORGANIZATION_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [],
            'to' => [
                'id' => OrganizationFixtures::ORGANIZATION_ID_1,
                'name' => 'PHP sem Rapadura',
                'description' => 'Comunidade de devs PHP do Estado do Ceará',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'owner' => AgentFixtures::AGENT_ID_1,
                'agents' => [],
                'parent' => null,
                'space' => null,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
        ],
        [
            'id' => '66e1bc85dffc242aeb0adec2',
            'userId' => AgentFixtures::AGENT_ID_1,
            'resourceId' => OrganizationFixtures::ORGANIZATION_ID_1,
            'priority' => 1,
            'datetime' => '2024-07-10T12:20:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [
                'id' => OrganizationFixtures::ORGANIZATION_ID_1,
                'name' => 'PHP sem Rapadura',
                'description' => 'Comunidade de devs PHP do Estado do Ceará',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'owner' => AgentFixtures::AGENT_ID_1,
                'agents' => [],
                'parent' => null,
                'space' => null,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'to' => [
                'id' => OrganizationFixtures::ORGANIZATION_ID_1,
                'name' => 'PHP com Rapadura',
                'description' => 'Comunidade de devs PHP do Estado do Ceará',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'owner' => AgentFixtures::AGENT_ID_1,
                'agents' => [],
                'parent' => null,
                'space' => null,
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
        foreach (self::IDS as $key => $organizationData) {
            $documentData = [
                'id' => $key,
                'userId' => $organizationData['createdBy'],
                'resourceId' => $organizationData['id'],
                'priority' => 1,
                'datetime' => $organizationData['createdAt'],
                'device' => 'linux',
                'platform' => 'api',
                'from' => [],
                'to' => $organizationData,
            ];

            /* @var OrganizationTimeline $object */
            $document = $this->serializer->denormalize($documentData, OrganizationTimeline::class);
            $manager->persist($document);
        }

        foreach (self::DOCUMENT_UPDATED as $documentData) {
            /* @var OrganizationTimeline $object */
            $document = $this->serializer->denormalize($documentData, OrganizationTimeline::class);
            $manager->persist($document);
        }

        $manager->flush();
    }
}

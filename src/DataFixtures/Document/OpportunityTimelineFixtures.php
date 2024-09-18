<?php

declare(strict_types=1);

namespace App\DataFixtures\Document;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\EventFixtures;
use App\DataFixtures\Entity\InitiativeFixtures;
use App\DataFixtures\Entity\OpportunityFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\DataFixtures\Entity\UserFixtures;
use App\Document\OpportunityTimeline;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class OpportunityTimelineFixtures extends Fixture
{
    public const array IDS = [
        '66eaf44519186a653156dafc' => OpportunityFixtures::OPPORTUNITIES[0],
        '66eaf44519186a653156dafd' => OpportunityFixtures::OPPORTUNITIES[1],
        '66eaf44619186a653156dafe' => OpportunityFixtures::OPPORTUNITIES[2],
        '66eaf44619186a653156daff' => OpportunityFixtures::OPPORTUNITIES[3],
        '66eaf44719186a653156db00' => OpportunityFixtures::OPPORTUNITIES[4],
        '66eaf44719186a653156db01' => OpportunityFixtures::OPPORTUNITIES[5],
        '66eaf44719186a653156db02' => OpportunityFixtures::OPPORTUNITIES[6],
        '66eaf44819186a653156db03' => OpportunityFixtures::OPPORTUNITIES[7],
        '66eaf44819186a653156db04' => OpportunityFixtures::OPPORTUNITIES[8],
        '66eaf44919186a653156db05' => OpportunityFixtures::OPPORTUNITIES[9],
    ];

    public const array DOCUMENT_UPDATED = [
        [
            'id' => '66eaf44919186a653156db06',
            'userId' => UserFixtures::USER_ID_1,
            'resourceId' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'priority' => 1,
            'datetime' => '2024-09-06T16:00:00+00:00',
            'device' => 'linux',
            'platform' => 'api',
            'from' => [
                'id' => OpportunityFixtures::OPPORTUNITY_ID_1,
                'name' => 'Festival de Literatura Nordestina',
                'description' => 'Aberto edital para inscrições no concurso de cordelistas que ocorrerá durante o Festival de Literatura Nordestina.',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'parent' => null,
                'space' => SpaceFixtures::SPACE_ID_1,
                'initiative' => InitiativeFixtures::INITIATIVE_ID_1,
                'event' => EventFixtures::EVENT_ID_1,
                'createdAt' => '2024-09-06T10:00:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'to' => [
                'id' => OpportunityFixtures::OPPORTUNITY_ID_1,
                'name' => 'Inscrição para o Concurso de Cordelistas - Festival de Literatura Nordestina',
                'description' => 'Aberto edital para inscrições no concurso de cordelistas que ocorrerá durante o Festival de Literatura Nordestina.',
                'createdBy' => AgentFixtures::AGENT_ID_1,
                'parent' => null,
                'space' => SpaceFixtures::SPACE_ID_1,
                'initiative' => InitiativeFixtures::INITIATIVE_ID_1,
                'event' => EventFixtures::EVENT_ID_1,
                'createdAt' => '2024-09-06T10:00:00+00:00',
                'updatedAt' => '2024-09-06T16:00:00+00:00',
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
        foreach (self::IDS as $key => $opportunityData) {
            $documentData = [
                'id' => $key,
                'userId' => $opportunityData['id'],
                'resourceId' => $opportunityData['id'],
                'priority' => 1,
                'datetime' => $opportunityData['createdAt'],
                'device' => 'linux',
                'platform' => 'api',
                'from' => [],
                'to' => $opportunityData,
            ];

            /* @var OpportunityTimeline $document */
            $document = $this->serializer->denormalize($documentData, OpportunityTimeline::class);
            $manager->persist($document);
        }

        foreach (self::DOCUMENT_UPDATED as $documentData) {
            /* @var OpportunityTimeline $document */
            $document = $this->serializer->denormalize($documentData, OpportunityTimeline::class);
            $manager->persist($document);
        }

        $manager->flush();
    }
}

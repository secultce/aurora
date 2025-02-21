<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\Phase;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class PhaseFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public const string PHASE_ID_PREFIX = 'phase';
    public const string PHASE_ID_1 = '2d73d4bd-d4bb-44ad-95a0-9b55b814d1c4';
    public const string PHASE_ID_2 = '4027d602-2de3-48df-b1e0-58c024eef059';
    public const string PHASE_ID_3 = '792bcdc0-79af-4893-8bb6-12f9fe60b61a';
    public const string PHASE_ID_4 = 'bab121fc-84be-43e8-81a4-cf9323032958';
    public const string PHASE_ID_5 = 'b2e8a4ca-bf04-4eac-bb93-3f98acb0ead8';
    public const string PHASE_ID_6 = 'fd9a0a1a-fb31-46d3-b237-b460231594a2';
    public const string PHASE_ID_7 = '41b57a40-33c3-42bb-8f16-45f29a995bf0';
    public const string PHASE_ID_8 = '7931cdbe-5ef4-4124-af20-e84bebe51956';
    public const string PHASE_ID_9 = '46a4d60b-6cc0-41f0-befe-edc23c569af1';
    public const string PHASE_ID_10 = '83fcead2-d55a-4484-87a2-00ef8736555f';
    public const string PHASE_ID_11 = '10d34ecd-4860-4b8c-9607-e4590dc31f7a';
    public const string PHASE_ID_12 = '3f254ab1-ecd6-450c-bf7e-cc3a2497b203';
    public const string PHASE_ID_13 = '495bb789-2e40-4cde-945d-575f1d2b4539';
    public const string PHASE_ID_14 = 'e63b6561-ff84-4d22-936e-9f9c87ae6b37';
    public const string PHASE_ID_15 = '0c06d626-d422-4c13-a680-291772e1eb30';

    public const array PHASES = [
        [
            'id' => self::PHASE_ID_1,
            'name' => 'Fase Inicial',
            'description' => 'Fase inicial do Concurso de Cordelistas',
            'startDate' => '2024-07-12',
            'endDate' => '2024-07-17',
            'status' => true,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_2,
                AgentFixtures::AGENT_ID_3,
            ],
            'createdAt' => '2024-09-01T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_2,
            'name' => 'Fase de validação',
            'description' => 'Fase de validação do Concurso de Cordelistas',
            'startDate' => '2024-07-18',
            'endDate' => '2024-07-22',
            'status' => true,
            'sequence' => 2,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_2,
                AgentFixtures::AGENT_ID_3,
            ],
            'createdAt' => '2024-09-02T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_3,
            'name' => 'Fase de recurso',
            'description' => 'Fase de recurso do Concurso de Cordelistas',
            'startDate' => '2024-07-23',
            'endDate' => '2024-07-26',
            'status' => true,
            'sequence' => 3,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_2,
                AgentFixtures::AGENT_ID_3,
            ],
            'createdAt' => '2024-09-03T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_4,
            'name' => 'Fase de submissão',
            'description' => 'Fase de submissão para as oficinas de Artesanato na Feira de Cultura Popular',
            'startDate' => '2024-08-10',
            'endDate' => '2024-08-15',
            'status' => true,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_2,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_2,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_4,
                AgentFixtures::AGENT_ID_6,
            ],
            'createdAt' => '2024-09-04T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_5,
            'name' => 'Fase de documentos',
            'description' => 'Fase de documentos para as oficinas de Artesanato na Feira de Cultura Popular',
            'startDate' => '2024-08-15',
            'endDate' => '2024-08-20',
            'status' => true,
            'sequence' => 2,
            'createdBy' => AgentFixtures::AGENT_ID_2,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_2,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_4,
                AgentFixtures::AGENT_ID_6,
            ],
            'createdAt' => '2024-09-05T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_6,
            'name' => 'Fase de submissão',
            'description' => 'Fase de submissão para o credenciamento de Quadrilhas Juninas - São João do Nordeste',
            'startDate' => '2024-07-15',
            'endDate' => '2024-07-18',
            'status' => true,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_3,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_3,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_1,
                AgentFixtures::AGENT_ID_5,
            ],
            'createdAt' => '2024-09-06T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_7,
            'name' => 'Fase de documentação',
            'description' => 'Fase de documentação para o credenciamento de Quadrilhas Juninas - São João do Nordest',
            'startDate' => '2024-07-12',
            'endDate' => '2024-07-17',
            'status' => true,
            'sequence' => 2,
            'createdBy' => AgentFixtures::AGENT_ID_3,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_3,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_1,
                AgentFixtures::AGENT_ID_5,
            ],
            'createdAt' => '2024-09-07T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_8,
            'name' => 'Fase de submissão',
            'description' => 'Fase de submissão de inscrição para o Festival de Danças Folclóricas - Encontro Nordestino',
            'startDate' => '2024-07-10',
            'endDate' => '2024-07-12',
            'status' => true,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_4,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_4,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_7,
                AgentFixtures::AGENT_ID_8,
            ],
            'createdAt' => '2024-09-08T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_9,
            'name' => 'Fase de documentação',
            'description' => 'Fase de documentação de inscrição para o Festival de Danças Folclóricas - Encontro Nordestino',
            'startDate' => '2024-08-22',
            'endDate' => '2024-08-24',
            'status' => true,
            'sequence' => 2,
            'createdBy' => AgentFixtures::AGENT_ID_4,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_4,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_7,
                AgentFixtures::AGENT_ID_8,
            ],
            'createdAt' => '2024-09-08T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_10,
            'name' => 'Fase de submissão',
            'description' => null,
            'startDate' => '2024-08-28',
            'endDate' => '2024-09-01',
            'status' => false,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_5,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_5,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_9,
                AgentFixtures::AGENT_ID_11,
            ],
            'createdAt' => '2024-09-10T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_11,
            'name' => 'Fase de submissão',
            'description' => null,
            'startDate' => '2024-05-01',
            'endDate' => '2024-05-05',
            'status' => false,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_6,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_6,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_10,
                AgentFixtures::AGENT_ID_11,
            ],
            'createdAt' => '2024-09-11T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_12,
            'name' => 'Fase de submissão',
            'description' => null,
            'startDate' => '2024-05-01',
            'endDate' => '2024-05-05',
            'status' => false,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_7,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_7,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_10,
                AgentFixtures::AGENT_ID_11,
            ],
            'createdAt' => '2024-09-12T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_13,
            'name' => 'Fase de submissão',
            'description' => null,
            'startDate' => '2024-05-01',
            'endDate' => '2024-05-05',
            'status' => false,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_8,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_8,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_5,
                AgentFixtures::AGENT_ID_7,
            ],
            'createdAt' => '2024-09-13T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_14,
            'name' => 'Fase de submissão',
            'description' => null,
            'startDate' => '2024-05-01',
            'endDate' => '2024-05-05',
            'status' => false,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_9,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_9,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_6,
                AgentFixtures::AGENT_ID_8,
            ],
            'createdAt' => '2024-09-14T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PHASE_ID_15,
            'name' => 'Fase de submissão',
            'description' => null,
            'startDate' => '2024-05-01',
            'endDate' => '2024-05-05',
            'status' => false,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_10,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_10,
            'extraFields' => [],
            'criteria' => [
                'communication-skill' => '0 a 10',
                'post-graduate' => 'sim ou nao',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_9,
                AgentFixtures::AGENT_ID_11,
            ],
            'createdAt' => '2024-09-11T15:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public const array PHASES_UPDATED = [
        [
            'id' => self::PHASE_ID_1,
            'name' => 'Fase de submissão',
            'description' => 'Fase inicial do Concurso de Cordelistas',
            'startDate' => '2024-07-12',
            'endDate' => '2024-07-17',
            'status' => true,
            'sequence' => 1,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'extraFields' => [
                'description' => 'Nessa fase deve ser realizado as inscrições',
            ],
            'reviewers' => [
                AgentFixtures::AGENT_ID_2,
                AgentFixtures::AGENT_ID_3,
            ],
            'createdAt' => '2024-09-01T10:00:00+00:00',
            'updatedAt' => '2024-09-01T10:30:00+00:00',
            'deletedAt' => null,
        ],
    ];

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct($entityManager, $tokenStorage);
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
            OpportunityFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createPhases($manager);
        $this->updatePhases($manager);
        $this->manualLogout();
    }

    private function createPhases(ObjectManager $manager): void
    {
        foreach (self::PHASES as $phaseData) {
            $phase = $this->serializer->denormalize($phaseData, Phase::class);
            $this->setReference(sprintf('%s-%s', self::PHASE_ID_PREFIX, $phaseData['id']), $phase);

            $this->manualLoginByAgent($phase->getCreatedBy()->getId()->toRfc4122());

            $manager->persist($phase);
        }

        $manager->flush();
    }

    private function updatePhases(ObjectManager $manager): void
    {
        foreach (self::PHASES_UPDATED as $phaseData) {
            $phaseObj = $this->getReference(sprintf('%s-%s', self::PHASE_ID_PREFIX, $phaseData['id']), Phase::class);

            /** @var Phase $phase */
            $phase = $this->serializer->denormalize($phaseData, Phase::class, context: ['object_to_populate' => $phaseObj]);

            $this->manualLoginByAgent($phase->getCreatedBy()->getId()->toRfc4122());

            $manager->persist($phase);
        }

        $manager->flush();
    }
}

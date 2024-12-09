<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\InscriptionPhase;
use App\Enum\InscriptionPhaseStatusEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class InscriptionPhaseFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public const string INSCRIPTION_PHASE_ID_PREFIX = 'inscription-phase';
    public const string INSCRIPTION_PHASE_ID_1 = 'dca40549-5c79-45a3-bf80-c7afb70c5f01';
    public const string INSCRIPTION_PHASE_ID_2 = 'cbbaee75-91ee-4b7a-b904-dcfe72be61a8';
    public const string INSCRIPTION_PHASE_ID_3 = '3e6a0bcf-7998-456b-a9ec-bb221ce0606c';
    public const string INSCRIPTION_PHASE_ID_4 = '5249d77c-6aa2-4c42-9024-c176388612ed';
    public const string INSCRIPTION_PHASE_ID_5 = 'bfb7ba79-14fb-4900-9d0e-6c7d5a8603f8';
    public const string INSCRIPTION_PHASE_ID_6 = '982d5d02-1c75-4fe0-ac86-76f7e3a93cb8';
    public const string INSCRIPTION_PHASE_ID_7 = '574f57ee-385a-4725-9ca2-f0b63062fa66';
    public const string INSCRIPTION_PHASE_ID_8 = '80e9c707-ea67-4e96-bf08-80b351e4b3ae';
    public const string INSCRIPTION_PHASE_ID_9 = 'e496703e-d4cb-42f5-bb77-21c8f14e1d29';
    public const string INSCRIPTION_PHASE_ID_10 = 'b6ba53f1-5796-45c1-ba8b-8717bf05ebfa';
    public const string INSCRIPTION_PHASE_ID_11 = 'd43c9034-b672-4c71-a01c-f97f1a12711e';
    public const string INSCRIPTION_PHASE_ID_12 = '3b9f8c02-f60f-48a0-b6d7-e2b70daed122';
    public const string INSCRIPTION_PHASE_ID_13 = '266e39a7-fd83-463b-ba41-319bfa261dda';
    public const string INSCRIPTION_PHASE_ID_14 = 'b9f0c44b-7ee2-4714-8342-9f5bdbee9903';
    public const string INSCRIPTION_PHASE_ID_15 = '882795aa-fc55-4fe7-a071-9e9638293798';
    public const string INSCRIPTION_PHASE_ID_16 = 'ec8adccb-7b18-4700-b988-b42b7b46fc5a';
    public const string INSCRIPTION_PHASE_ID_17 = '0619cd27-d5c0-4cb2-a77d-8feb0f0947c6';
    public const string INSCRIPTION_PHASE_ID_18 = 'f28856ce-b7f9-454d-9c6a-ec052d05d25f';
    public const string INSCRIPTION_PHASE_ID_19 = '5b5deace-507d-44aa-a0b3-24de33b96613';
    public const string INSCRIPTION_PHASE_ID_20 = 'c9d7e462-b972-4148-a388-a303b176f3da';
    public const string INSCRIPTION_PHASE_ID_21 = '6b94ea4e-112e-4e58-8355-63bf4085c011';
    public const string INSCRIPTION_PHASE_ID_22 = 'b6864200-3335-463c-b85c-8d189fdcb78a';
    public const string INSCRIPTION_PHASE_ID_23 = '991c923c-ef94-4d45-9186-ece678f5cbca';
    public const string INSCRIPTION_PHASE_ID_24 = 'fb8dae3c-bb1c-49aa-b803-18c352eea026';
    public const string INSCRIPTION_PHASE_ID_25 = '22dde907-9b47-4e3a-a778-18cd9823fb1f';
    public const string INSCRIPTION_PHASE_ID_26 = '146c414d-01bd-4fd1-8032-5bd748043e74';

    public const array DATA = [
        [
            'id' => self::INSCRIPTION_PHASE_ID_1,
            'agent' => AgentFixtures::AGENT_ID_5,
            'phase' => PhaseFixtures::PHASE_ID_1,
            'status' => InscriptionPhaseStatusEnum::INACTIVE->value,
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_2,
            'agent' => AgentFixtures::AGENT_ID_6,
            'phase' => PhaseFixtures::PHASE_ID_1,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:31:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_3,
            'agent' => AgentFixtures::AGENT_ID_5,
            'phase' => PhaseFixtures::PHASE_ID_2,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:33:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_4,
            'agent' => AgentFixtures::AGENT_ID_6,
            'phase' => PhaseFixtures::PHASE_ID_2,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:34:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_5,
            'agent' => AgentFixtures::AGENT_ID_5,
            'phase' => PhaseFixtures::PHASE_ID_3,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:35:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_6,
            'agent' => AgentFixtures::AGENT_ID_6,
            'phase' => PhaseFixtures::PHASE_ID_3,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:36:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_7,
            'agent' => AgentFixtures::AGENT_ID_1,
            'phase' => PhaseFixtures::PHASE_ID_4,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:37:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_8,
            'agent' => AgentFixtures::AGENT_ID_5,
            'phase' => PhaseFixtures::PHASE_ID_4,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:38:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_9,
            'agent' => AgentFixtures::AGENT_ID_6,
            'phase' => PhaseFixtures::PHASE_ID_4,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:39:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_10,
            'agent' => AgentFixtures::AGENT_ID_11,
            'phase' => PhaseFixtures::PHASE_ID_4,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:40:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_11,
            'agent' => AgentFixtures::AGENT_ID_1,
            'phase' => PhaseFixtures::PHASE_ID_5,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:41:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_12,
            'agent' => AgentFixtures::AGENT_ID_5,
            'phase' => PhaseFixtures::PHASE_ID_5,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:42:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_13,
            'agent' => AgentFixtures::AGENT_ID_6,
            'phase' => PhaseFixtures::PHASE_ID_5,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:43:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_14,
            'agent' => AgentFixtures::AGENT_ID_11,
            'phase' => PhaseFixtures::PHASE_ID_5,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:44:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_15,
            'agent' => AgentFixtures::AGENT_ID_7,
            'phase' => PhaseFixtures::PHASE_ID_6,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:45:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_16,
            'agent' => AgentFixtures::AGENT_ID_8,
            'phase' => PhaseFixtures::PHASE_ID_6,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:46:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_17,
            'agent' => AgentFixtures::AGENT_ID_9,
            'phase' => PhaseFixtures::PHASE_ID_6,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:47:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_18,
            'agent' => AgentFixtures::AGENT_ID_7,
            'phase' => PhaseFixtures::PHASE_ID_7,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:48:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_19,
            'agent' => AgentFixtures::AGENT_ID_8,
            'phase' => PhaseFixtures::PHASE_ID_7,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_20,
            'agent' => AgentFixtures::AGENT_ID_9,
            'phase' => PhaseFixtures::PHASE_ID_7,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:50:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_21,
            'agent' => AgentFixtures::AGENT_ID_1,
            'phase' => PhaseFixtures::PHASE_ID_8,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:51:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_22,
            'agent' => AgentFixtures::AGENT_ID_10,
            'phase' => PhaseFixtures::PHASE_ID_8,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:52:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_23,
            'agent' => AgentFixtures::AGENT_ID_1,
            'phase' => PhaseFixtures::PHASE_ID_9,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:53:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_24,
            'agent' => AgentFixtures::AGENT_ID_10,
            'phase' => PhaseFixtures::PHASE_ID_9,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_25,
            'agent' => AgentFixtures::AGENT_ID_1,
            'phase' => PhaseFixtures::PHASE_ID_10,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:55:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_PHASE_ID_26,
            'agent' => AgentFixtures::AGENT_ID_10,
            'phase' => PhaseFixtures::PHASE_ID_10,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:56:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public const array DATA_UPDATED = [
        [
            'id' => self::INSCRIPTION_PHASE_ID_1,
            'agent' => AgentFixtures::AGENT_ID_1,
            'phase' => PhaseFixtures::PHASE_ID_2,
            'status' => InscriptionPhaseStatusEnum::ACTIVE->value,
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => '2024-07-10T12:20:00+00:00',
            'deletedAt' => null,
        ],
    ];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TokenStorageInterface $tokenStorage,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct($entityManager, $tokenStorage);
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
            PhaseFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->truncateTable(InscriptionPhase::class);
        $this->createInscriptionPhases($manager);
        $this->updateInscriptionPhases($manager);
        $this->manualLogout();
    }

    private function createInscriptionPhases(ObjectManager $manager): void
    {
        foreach (self::DATA as $inscriptionPhaseData) {
            $inscriptionPhase = $this->mountInscriptionPhase($inscriptionPhaseData);

            $this->manualLoginByAgent($inscriptionPhaseData['agent']);

            $this->setReference(sprintf('%s-%s', self::INSCRIPTION_PHASE_ID_PREFIX, $inscriptionPhaseData['id']), $inscriptionPhase);

            $manager->persist($inscriptionPhase);
        }

        $manager->flush();
    }

    private function updateInscriptionPhases(ObjectManager $manager): void
    {
        foreach (self::DATA_UPDATED as $inscriptionPhaseData) {
            $inscriptionPhaseObj = $this->getReference(sprintf('%s-%s', self::INSCRIPTION_PHASE_ID_PREFIX, $inscriptionPhaseData['id']), InscriptionPhase::class);

            $inscriptionPhase = $this->mountInscriptionPhase($inscriptionPhaseData, ['object_to_populate' => $inscriptionPhaseObj]);

            $this->manualLoginByAgent($inscriptionPhaseData['agent']);

            $manager->persist($inscriptionPhase);
        }

        $manager->flush();
    }

    private function mountInscriptionPhase(mixed $inscriptionPhaseData, array $context = []): InscriptionPhase
    {
        /** @var InscriptionPhase $inscriptionPhase */
        $inscriptionPhase = $this->serializer->denormalize($inscriptionPhaseData, InscriptionPhase::class, context: $context);

        $inscriptionPhase->setAgent($this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $inscriptionPhaseData['agent'])));
        $inscriptionPhase->setPhase($this->getReference(sprintf('%s-%s', PhaseFixtures::PHASE_ID_PREFIX, $inscriptionPhaseData['phase'])));

        return $inscriptionPhase;
    }
}

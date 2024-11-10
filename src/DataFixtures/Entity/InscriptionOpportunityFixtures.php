<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\InscriptionOpportunity;
use App\Enum\InscriptionOpportunityStatus;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class InscriptionOpportunityFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public const string INSCRIPTION_OPPORTUNITY_ID_PREFIX = 'inscription-opportunity';
    public const string INSCRIPTION_OPPORTUNITY_ID_1 = '91590354-87aa-4798-8b03-8731f4d5b478';
    public const string INSCRIPTION_OPPORTUNITY_ID_2 = 'f1d56881-7e32-4b41-9b3e-f8cd746a03c2';
    public const string INSCRIPTION_OPPORTUNITY_ID_3 = '7b5ae65c-ac7f-4c98-a33a-e3f39ddf5abd';
    public const string INSCRIPTION_OPPORTUNITY_ID_4 = '90e20f1a-0bb7-464a-82f1-01375dd32167';
    public const string INSCRIPTION_OPPORTUNITY_ID_5 = '01d1d4de-1503-47e5-8cbc-3da947e32e3a';
    public const string INSCRIPTION_OPPORTUNITY_ID_6 = '2b61a0ca-c690-450a-9986-297780471c82';
    public const string INSCRIPTION_OPPORTUNITY_ID_7 = 'e0beee7e-d4c7-48e8-8e3d-dcd9fbad5752';
    public const string INSCRIPTION_OPPORTUNITY_ID_8 = 'f23c6e73-9caf-4f22-88bb-acd328c4bb68';
    public const string INSCRIPTION_OPPORTUNITY_ID_9 = '5fd49a23-96c6-4629-8a5d-b8ab205837d2';
    public const string INSCRIPTION_OPPORTUNITY_ID_10 = '94f3b687-3353-4155-aa7f-5986c363b5ae';

    public const array DATA = [
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_1,
            'agent' => AgentFixtures::AGENT_ID_1,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'status' => InscriptionOpportunityStatus::INACTIVE,
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_2,
            'agent' => AgentFixtures::AGENT_ID_2,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_2,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_3,
            'agent' => AgentFixtures::AGENT_ID_3,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_3,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_4,
            'agent' => AgentFixtures::AGENT_ID_4,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_4,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_5,
            'agent' => AgentFixtures::AGENT_ID_5,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_5,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_6,
            'agent' => AgentFixtures::AGENT_ID_6,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_6,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_7,
            'agent' => AgentFixtures::AGENT_ID_7,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_7,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_8,
            'agent' => AgentFixtures::AGENT_ID_8,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_8,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_9,
            'agent' => AgentFixtures::AGENT_ID_9,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_9,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_10,
            'agent' => AgentFixtures::AGENT_ID_10,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_10,
            'status' => InscriptionOpportunityStatus::ACTIVE,
            'createdAt' => '2024-08-14T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public const array DATA_UPDATED = [
        [
            'id' => self::INSCRIPTION_OPPORTUNITY_ID_1,
            'agent' => AgentFixtures::AGENT_ID_1,
            'opportunity' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'status' => InscriptionOpportunityStatus::ACTIVE,
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
            OpportunityFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createSpaces($manager);
        $this->updateSpaces($manager);
        $this->manualLogout();
    }

    private function createSpaces(ObjectManager $manager): void
    {
        foreach (self::DATA as $inscriptionOpportunityData) {
            $inscriptionOpportunity = $this->mountSpace($inscriptionOpportunityData);

            $this->manualLoginByAgent($inscriptionOpportunityData['agent']);

            $this->setReference(sprintf('%s-%s', self::INSCRIPTION_OPPORTUNITY_ID_PREFIX, $inscriptionOpportunityData['id']), $inscriptionOpportunity);

            $manager->persist($inscriptionOpportunity);
        }

        $manager->flush();
    }

    private function updateSpaces(ObjectManager $manager): void
    {
        foreach (self::DATA_UPDATED as $inscriptionOpportunityData) {
            $inscriptionOpportunityObj = $this->getReference(sprintf('%s-%s', self::INSCRIPTION_OPPORTUNITY_ID_PREFIX, $inscriptionOpportunityData['id']), InscriptionOpportunity::class);

            $inscriptionOpportunity = $this->mountSpace($inscriptionOpportunityData, ['object_to_populate' => $inscriptionOpportunityObj]);

            $this->manualLoginByAgent($inscriptionOpportunityData['agent']);

            $manager->persist($inscriptionOpportunity);
        }

        $manager->flush();
    }

    private function mountSpace(mixed $inscriptionOpportunityData, array $context = []): InscriptionOpportunity
    {
        /** @var InscriptionOpportunity $inscriptionOpportunity */
        $inscriptionOpportunity = $this->serializer->denormalize($inscriptionOpportunityData, InscriptionOpportunity::class, context: $context);

        $inscriptionOpportunity->setAgent($this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $inscriptionOpportunityData['agent'])));
        $inscriptionOpportunity->setOpportunity($this->getReference(sprintf('%s-%s', OpportunityFixtures::OPPORTUNITY_ID_PREFIX, $inscriptionOpportunityData['opportunity'])));

        return $inscriptionOpportunity;
    }
}

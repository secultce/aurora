<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Agent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

final class AgentFixtures extends Fixture
{
    public const string AGENT_ID_PREFIX = 'agent';
    public const string AGENT_ID_1 = '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566';
    public const string AGENT_ID_2 = '84a5b3d1-a7a4-49a6-aff8-902a325f97f9';
    public const string AGENT_ID_3 = '0da862ef-0dc7-45c4-9bed-751ff379e9d3';
    public const string AGENT_ID_4 = 'f07a3bd3-ce3a-4608-b2ae-6a22048630c2';
    public const string AGENT_ID_5 = '79cd7a39-2e48-4f09-b091-04cadf8e8a55';
    public const string AGENT_ID_6 = 'a9a9acc3-3cf5-4631-a29c-2cc31f9278e7';
    public const string AGENT_ID_7 = 'd250a8c9-b4f9-41e9-bb8a-e78606001439';
    public const string AGENT_ID_8 = '12923f16-b744-41ad-bd45-ebf99a599801';
    public const string AGENT_ID_9 = '37a5640f-ca46-4612-9e53-a797f3b8f11c';
    public const string AGENT_ID_10 = 'd737554f-258e-4360-a653-177551f5b1a5';

    public const array AGENTS = [
        [
            'id' => self::AGENT_ID_1,
            'name' => 'Alessandro',
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_2,
            'name' => 'Henrique',
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_3,
            'name' => 'Anna Kelly',
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_4,
            'name' => 'Sara Jenifer',
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_5,
            'name' => 'Talyson',
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_6,
            'name' => 'Raquel',
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_7,
            'name' => 'Lucas',
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_8,
            'name' => 'Maria',
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_9,
            'name' => 'Abner',
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_10,
            'name' => 'Paulo',
            'createdAt' => '2024-08-14T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::AGENTS as $agentData) {
            /* @var Agent $agent */
            $agent = $this->serializer->denormalize($agentData, Agent::class);

            $this->setReference(sprintf('%s-%s', self::AGENT_ID_PREFIX, $agentData['id']), $agent);

            $manager->persist($agent);
        }

        $manager->flush();
    }
}

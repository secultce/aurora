<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

final class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public const string EVENT_ID_PREFIX = 'event';
    public const string EVENT_ID_1 = '8042b9aa-91b9-43f7-8829-101da3086a27';
    public const string EVENT_ID_2 = 'f718952a-1bbf-4d7b-85aa-9e6c2d901cb1';
    public const string EVENT_ID_3 = '4b92555b-9f6b-4163-8977-c38af0df36b0';
    public const string EVENT_ID_4 = 'f6b6ef5d-2b23-45d2-a7e3-dd5cae67c98a';
    public const string EVENT_ID_5 = '474a2771-f941-46c6-969e-1e5ceb166444';
    public const string EVENT_ID_6 = '64f6d8a0-6326-4c15-bec1-d4531720f578';
    public const string EVENT_ID_7 = 'a963d40a-f6e7-4eab-a9c9-3222dfa443f2';
    public const string EVENT_ID_8 = '96318947-df03-41c9-be75-095a85c12e96';
    public const string EVENT_ID_9 = 'cb3b5e40-604b-49e5-a21f-442b43a8a3a9';
    public const string EVENT_ID_10 = '9f0e3630-f9e1-42ca-8e6b-b1dcaa006797';

    public const array EVENTS = [
        [
            'id' => self::EVENT_ID_1,
            'name' => 'Festival Sertão Criativo',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_3,
            'project' => ProjectFixtures::PROJECT_ID_2,
            'parent' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_2,
            'name' => 'PHP com Rapadura 10 anos',
            'agentGroup' => null,
            'space' => null,
            'project' => null,
            'parent' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_3,
            'name' => 'Músical o vento da Caatinga',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_5,
            'project' => ProjectFixtures::PROJECT_ID_7,
            'parent' => null,
            'createdBy' => AgentFixtures::AGENT_ID_2,
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_4,
            'name' => 'Encontro de Saberes',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_4,
            'project' => ProjectFixtures::PROJECT_ID_9,
            'parent' => self::EVENT_ID_3,
            'createdBy' => AgentFixtures::AGENT_ID_2,
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_5,
            'name' => 'Vozes do Interior',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_4,
            'project' => ProjectFixtures::PROJECT_ID_5,
            'parent' => self::EVENT_ID_3,
            'createdBy' => AgentFixtures::AGENT_ID_3,
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_6,
            'name' => 'Cores do Sertão',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_3,
            'project' => ProjectFixtures::PROJECT_ID_10,
            'parent' => self::EVENT_ID_3,
            'createdBy' => AgentFixtures::AGENT_ID_3,
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_7,
            'name' => 'Raízes do Sertão',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_6,
            'project' => ProjectFixtures::PROJECT_ID_1,
            'parent' => self::EVENT_ID_3,
            'createdBy' => AgentFixtures::AGENT_ID_4,
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_8,
            'name' => 'Festival da Rapadura',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_6,
            'project' => ProjectFixtures::PROJECT_ID_2,
            'parent' => null,
            'createdBy' => AgentFixtures::AGENT_ID_4,
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_9,
            'name' => 'Cultura em ação',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_10,
            'project' => ProjectFixtures::PROJECT_ID_4,
            'parent' => null,
            'createdBy' => AgentFixtures::AGENT_ID_5,
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::EVENT_ID_10,
            'name' => 'Nordeste Literário',
            'agentGroup' => null,
            'space' => SpaceFixtures::SPACE_ID_6,
            'project' => ProjectFixtures::PROJECT_ID_1,
            'parent' => null,
            'createdBy' => AgentFixtures::AGENT_ID_5,
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
        foreach (self::EVENTS as $eventData) {
            /* @var Event $event */
            $event = $this->serializer->denormalize($eventData, Event::class);

            $event->setCreatedBy($this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $eventData['createdBy'])));

            if (null !== $eventData['agentGroup']) {
                $agentGroup = $this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $eventData['agentGroup']));
                $event->setAgentGroup($agentGroup);
            }

            if (null !== $eventData['space']) {
                $space = $this->getReference(sprintf('%s-%s', SpaceFixtures::SPACE_ID_PREFIX, $eventData['space']));
                $event->setSpace($space);
            }

            if (null !== $eventData['project']) {
                $project = $this->getReference(sprintf('%s-%s', ProjectFixtures::PROJECT_ID_PREFIX, $eventData['project']));
                $event->setProject($project);
            }

            if (null !== $eventData['parent']) {
                $parent = $this->getReference(sprintf('%s-%s', self::EVENT_ID_PREFIX, $eventData['parent']));
                $event->setParent($parent);
            }

            $this->setReference(sprintf('%s-%s', self::EVENT_ID_PREFIX, $eventData['id']), $event);

            $manager->persist($event);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
            SpaceFixtures::class,
            ProjectFixtures::class,
        ];
    }
}

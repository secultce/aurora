<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

final class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public const string PROJECT_ID_PREFIX = 'project';
    public const string PROJECT_ID_1 = 'f0774ecd-4860-4b8c-9607-32090dc31f71';
    public const string PROJECT_ID_2 = 'a65a9657-c527-4f33-a06e-60c2e219136e';
    public const string PROJECT_ID_3 = 'd12efd05-efc2-457a-a59e-8183147ed9ec';
    public const string PROJECT_ID_4 = 'd68dc96e-a864-4bb1-ab3d-dec2c2dbae7b';
    public const string PROJECT_ID_5 = 'd4301de5-7f5d-4817-bae0-3152674ade73';
    public const string PROJECT_ID_6 = '5d850939-26ef-49b5-a912-f825967271a4';
    public const string PROJECT_ID_7 = '26c2aaf2-bf08-41d9-b036-7d6b4e56c350';
    public const string PROJECT_ID_8 = '7241b715-450a-42db-b707-225dc3ab988c';
    public const string PROJECT_ID_9 = '7cb6f1b8-f34e-4218-ab41-f10b0f74e4d1';
    public const string PROJECT_ID_10 = '8c4c48bd-6e63-4b62-858b-066969c49f66';

    public const array PROJECTS = [
        [
            'id' => self::PROJECT_ID_1,
            'name' => 'Vozes do Sertão',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_2,
            'name' => 'Raízes e Tradições',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_3,
            'name' => 'Ritmos do Mundo',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_4,
            'name' => 'AxeZumbi',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_5,
            'name' => 'Repente e Viola',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_6,
            'name' => 'Pé de Serra Cultural',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_7,
            'name' => 'Musicalizando',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_8,
            'name' => 'Baião de Dois',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_9,
            'name' => 'Retalhos do Nordeste',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => self::PROJECT_ID_8,
            'space' => null,
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::PROJECT_ID_10,
            'name' => 'Arte da Caatinga',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => self::PROJECT_ID_9,
            'space' => null,
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
        foreach (self::PROJECTS as $projectData) {
            /* @var Project $project */
            $project = $this->serializer->denormalize($projectData, Project::class);
            $project->setCreatedBy($this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $projectData['createdBy'])));

            $this->setReference(sprintf('%s-%s', self::PROJECT_ID_PREFIX, $projectData['id']), $project);

            $manager->persist($project);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
            SpaceFixtures::class,
        ];
    }
}

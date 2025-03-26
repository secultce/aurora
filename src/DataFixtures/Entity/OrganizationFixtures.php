<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\Organization;
use App\Enum\SocialNetworkEnum;
use App\Service\Interface\FileServiceInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class OrganizationFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public const string ORGANIZATION_ID_PREFIX = 'organization';
    public const string ORGANIZATION_ID_1 = 'bc89ea8d-6ad7-4cb8-92a9-b56ce203c7dd';
    public const string ORGANIZATION_ID_2 = 'a65aa657-c537-1f33-c06e-31c2e219136e';
    public const string ORGANIZATION_ID_3 = 'd12ead05-ef32-157a-c59e-4a83147ed9ec';
    public const string ORGANIZATION_ID_4 = 'd68da96e-a834-1bb1-cb3d-5ac2c2dbae7b';
    public const string ORGANIZATION_ID_5 = 'd430ade5-7f3d-1817-cae0-7152674ade73';
    public const string ORGANIZATION_ID_6 = '5d85a939-263f-19b5-c912-7825967271a4';
    public const string ORGANIZATION_ID_7 = '26c2aaf2-bf38-11d9-c036-7d6b4e56c350';
    public const string ORGANIZATION_ID_8 = '7241a715-453a-12db-c707-725dc3ab988c';
    public const string ORGANIZATION_ID_9 = '7cb6a1b8-f33e-1218-cb41-820b0f74e4d1';
    public const string ORGANIZATION_ID_10 = '8c4ca8bd-6e33-1b62-c58b-a66969c49f66';

    public const array ORGANIZATIONS = [
        [
            'id' => self::ORGANIZATION_ID_1,
            'name' => 'PHP sem Rapadura',
            'image' => null,
            'description' => 'Comunidade de devs PHP do Estado do Ceará',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'owner' => AgentFixtures::AGENT_ID_1,
            'agents' => [],
            'parent' => null,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'phpcomrapadura',
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_2,
            'name' => 'Grupo de Capoeira Axé Zumbi',
            'image' => null,
            'description' => 'Grupo de Capoeira Axé Zumbi',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'owner' => AgentFixtures::AGENT_ID_1,
            'agents' => [
                AgentFixtures::AGENT_ID_1,
                AgentFixtures::AGENT_ID_2,
            ],
            'parent' => null,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'capoeiraaxezumbi',
            ],
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_3,
            'name' => 'Devs do Sertão',
            'image' => null,
            'description' => 'Grupo de devs que se reúnem velas veredas do sertão',
            'createdBy' => AgentFixtures::AGENT_ID_3,
            'owner' => AgentFixtures::AGENT_ID_3,
            'parent' => null,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'devsdosertao',
            ],
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_4,
            'name' => 'SertãoDev',
            'image' => null,
            'description' => 'Cooperativa de devs do Estado do Ceará',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'owner' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'sertaodev',
            ],
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_5,
            'name' => 'De RapEnte',
            'image' => null,
            'description' => 'Grupo de Rap e Repente da caatinga nordestina',
            'createdBy' => AgentFixtures::AGENT_ID_3,
            'owner' => AgentFixtures::AGENT_ID_3,
            'parent' => null,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'grupoderapente',
            ],
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_6,
            'name' => 'Comunidade Vida com Cristo',
            'image' => null,
            'description' => 'Grupo de oração destinado a cristãos de boa fé',
            'createdBy' => AgentFixtures::AGENT_ID_2,
            'owner' => AgentFixtures::AGENT_ID_2,
            'parent' => null,
            'space' => null,
            'extraFields' => [
                'locations' => [
                    'R. Principal, 100, Centro, Fortaleza-CE, 60100-000',
                    'R. Secondária, 200, Aldeota, Fortaleza-CE, 60200-000',
                ],
            ],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'comunidadevidacomcristo',
            ],
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_7,
            'name' => 'Candomblé Raizes do Brasil ',
            'image' => null,
            'description' => 'Grupo de praticantes do candomblé - Natal-RN',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'owner' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'candombleraizesdobrasil',
            ],
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_8,
            'name' => 'Baião de Dev',
            'image' => null,
            'description' => 'Grupo de desenvolvedores do nordeste',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'owner' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'baiaodedev',
            ],
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_9,
            'name' => 'PHPeste',
            'image' => null,
            'description' => 'Organização da Conferencia de PHP do Nordeste',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'owner' => AgentFixtures::AGENT_ID_1,
            'parent' => self::ORGANIZATION_ID_8,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'phpeste',
            ],
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::ORGANIZATION_ID_10,
            'name' => 'Banda de Forró tô nem veno',
            'image' => null,
            'description' => 'Banda de forró formada com pessoas de baixa ou nenhuma visão',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'owner' => AgentFixtures::AGENT_ID_1,
            'parent' => self::ORGANIZATION_ID_9,
            'space' => null,
            'extraFields' => [],
            'socialNetworks' => [
                SocialNetworkEnum::INSTAGRAM->value => 'forrotonemveno',
            ],
            'createdAt' => '2024-08-14T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public const array ORGANIZATIONS_UPDATED = [
        [
            'id' => self::ORGANIZATION_ID_1,
            'name' => 'PHP com Rapadura',
            'image' => null,
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
    ];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TokenStorageInterface $tokenStorage,
        private readonly SerializerInterface $serializer,
        private readonly FileServiceInterface $fileService,
        private readonly ParameterBagInterface $parameterBag,
    ) {
        parent::__construct($entityManager, $tokenStorage);
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createOrganizations($manager);
        $this->updateOrganizations($manager);
        $this->manualLogout();
    }

    private function mountOrganization(array $organizationData, array $context = []): Organization
    {
        $agents = $organizationData['agents'] ?? [];
        unset($organizationData['agents']);

        /** @var Organization $organization */
        $organization = $this->serializer->denormalize($organizationData, Organization::class, context: $context);

        foreach ($agents ?? [] as $agentId) {
            $organization->addAgent(
                $this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $agentId))
            );
        }

        $organization->setCreatedBy($this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $organizationData['createdBy'])));
        $organization->setOwner($this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $organizationData['owner'])));

        return $organization;
    }

    private function createOrganizations(ObjectManager $manager): void
    {
        $counter = 0;

        foreach (self::ORGANIZATIONS as $organizationData) {
            if (5 > $counter) {
                $file = $this->fileService->uploadImage($this->parameterBag->get('app.dir.organization.profile'), ImageFixtures::getOrganizationImage());
                $organizationData['image'] = $file;
            }

            $organization = $this->mountOrganization($organizationData);

            $this->setReference(sprintf('%s-%s', self::ORGANIZATION_ID_PREFIX, $organizationData['id']), $organization);

            $this->manualLoginByAgent($organizationData['createdBy']);

            $manager->persist($organization);
            $counter++;
        }

        $manager->flush();
    }

    public function updateOrganizations(ObjectManager $manager): void
    {
        foreach (self::ORGANIZATIONS_UPDATED as $organizationData) {
            $organizationObj = $this->getReference(sprintf('%s-%s', self::ORGANIZATION_ID_PREFIX, $organizationData['id']), Organization::class);

            $organization = $this->mountOrganization($organizationData, ['object_to_populate' => $organizationObj]);

            $this->manualLoginByAgent($organizationData['createdBy']);

            $manager->persist($organization);
        }

        $manager->flush();
    }
}

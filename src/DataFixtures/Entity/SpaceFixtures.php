<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\Space;
use App\Service\Interface\FileServiceInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class SpaceFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public const string SPACE_ID_PREFIX = 'space';
    public const string SPACE_ID_1 = '69461af3-52f2-4c6b-ad30-ce92e478e9bd';
    public const string SPACE_ID_2 = 'ae32b8a5-25a8-4b80-b415-4237a8484186';
    public const string SPACE_ID_3 = '608756eb-4830-49f2-ae14-1160ca5252f4';
    public const string SPACE_ID_4 = '25dc221a-f4a6-4e40-94c3-73b1d553f2c1';
    public const string SPACE_ID_5 = '46137ea7-6ca9-4782-b940-b45c74716a4f';
    public const string SPACE_ID_6 = 'a54d5bc6-0748-4554-aaf9-80cad467f991';
    public const string SPACE_ID_7 = 'd53c4e9b-b72c-4b22-b18d-be8f404cd242';
    public const string SPACE_ID_8 = '86071ac5-021c-4e44-a200-7159fe57a810';
    public const string SPACE_ID_9 = 'eaf6a58d-ff9b-4446-8e1a-9bb9164adc74';
    public const string SPACE_ID_10 = 'b4a49f4d-25ca-40f9-bac2-e72383b689ed';

    public const array SPACES = [
        [
            'id' => self::SPACE_ID_1,
            'name' => 'Cultura',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'extraFields' => [
                'type' => 'Instituição Cultural',
                'description' => 'A Secretaria da Cultura (SECULT) é responsável por fomentar a arte e a cultura no estado, organizando eventos e oferecendo apoio a iniciativas locais.',
                'location' => 'Complexo Estação das Artes - R. Dr. João Moreira, 540 - Centro, Fortaleza - CE, 60030-000',
                'accessibility' => ['Banheiros adaptados', 'Rampa de acesso', 'Elevador adaptado', 'Sinalização tátil'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
            ],
            'tags' => [
                TagFixtures::TAG_ID_1,
                TagFixtures::TAG_ID_2,
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_2,
            'name' => 'Sítio das Artes',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'extraFields' => [
                'type' => 'Centro Cultural',
                'description' => 'O Sítio das Artes é um espaço dedicado à promoção de atividades culturais e oficinas artísticas, com uma vasta programação para todas as idades.',
                'location' => 'Av. das Artes, 123 – Fortaleza/CE – CEP: 60123-123',
                'accessibility' => ['Banheiros adaptados', 'Rampa de acesso'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_4,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
            ],
            'tags' => [
                TagFixtures::TAG_ID_3,
                TagFixtures::TAG_ID_4,
            ],
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_3,
            'name' => 'Galeria Caatinga',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_2,
            'parent' => self::SPACE_ID_2,
            'extraFields' => [
                'type' => 'Galeria de Arte',
                'description' => 'A Galeria Caatinga é especializada em exposições de artistas regionais, com foco na arte nordestina e obras inspiradas pela fauna e flora do sertão.',
                'location' => 'Rua do Sertão, 123 – Fortaleza/CE – CEP: 60123-456',
                'accessibility' => ['Elevador adaptado', 'Sinalização tátil', 'Banheiros acessíveis'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_10,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
            ],
            'tags' => [
                TagFixtures::TAG_ID_5,
                TagFixtures::TAG_ID_6,
            ],
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_4,
            'name' => 'Recanto do Cordel',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => self::SPACE_ID_3,
            'extraFields' => [
                'type' => 'Centro de Literatura',
                'description' => 'O Recanto do Cordel é um ponto de encontro para escritores e leitores de literatura de cordel, com eventos de declamação e oficinas.',
                'location' => 'Rua das Letras, 456 – Fortaleza/CE – CEP: 60123-789',
                'accessibility' => ['Banheiros adaptados', 'Rampa de acesso'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_6,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
            ],
            'tags' => [
                TagFixtures::TAG_ID_7,
                TagFixtures::TAG_ID_8,
            ],
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_5,
            'name' => 'Ritmos do Mundo',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => self::SPACE_ID_3,
            'extraFields' => [
                'type' => 'Centro Musical',
                'description' => 'O Ritmos do Mundo promove eventos musicais de várias partes do mundo, com foco na diversidade e na fusão de estilos.',
                'location' => 'Av. das Nações, 234 – Fortaleza/CE – CEP: 60123-987',
                'accessibility' => ['Rampa de acesso', 'Banheiros acessíveis', 'Sinalização em braile'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_4,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
            ],
            'tags' => [
                TagFixtures::TAG_ID_9,
                TagFixtures::TAG_ID_10,
            ],
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_6,
            'name' => 'Casa do Sertão',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => self::SPACE_ID_3,
            'extraFields' => [
                'type' => 'Museu',
                'description' => 'A Casa do Sertão é um museu dedicado à história e cultura do sertão nordestino, com exposições interativas e oficinas educativas.',
                'location' => 'Praça do Sertão, 567 – Fortaleza/CE – CEP: 60123-654',
                'accessibility' => ['Elevador adaptado', 'Rampas de acesso'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_9,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
            ],
            'tags' => [
                TagFixtures::TAG_ID_1,
                TagFixtures::TAG_ID_2,
                TagFixtures::TAG_ID_5,
            ],
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_7,
            'name' => 'Vila do Baião',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => self::SPACE_ID_6,
            'extraFields' => [
                'type' => 'Centro de Música',
                'description' => 'A Vila do Baião é um espaço dedicado à preservação e promoção do forró e de outros ritmos nordestinos, com aulas, ensaios e apresentações.',
                'location' => 'Rua do Baião, 678 – Fortaleza/CE – CEP: 60123-321',
                'accessibility' => ['Banheiros adaptados', 'Rampa de acesso'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_4,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
            ],
            'tags' => [
                TagFixtures::TAG_ID_5,
                TagFixtures::TAG_ID_3,
                TagFixtures::TAG_ID_9,
                TagFixtures::TAG_ID_10,
            ],
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_8,
            'name' => 'Centro Cultural Asa Branca',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'extraFields' => [
                'type' => 'Centro Cultural',
                'description' => 'O Centro Cultural Asa Branca oferece uma programação diversificada com exposições, apresentações teatrais e oficinas de arte.',
                'location' => 'Av. Asa Branca, 789 – Fortaleza/CE – CEP: 60123-852',
                'accessibility' => ['Elevador adaptado', 'Rampas de acesso'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
            ],
            'tags' => [
                TagFixtures::TAG_ID_1,
                TagFixtures::TAG_ID_2,
                TagFixtures::TAG_ID_3,
                TagFixtures::TAG_ID_4,
                TagFixtures::TAG_ID_5,
            ],
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_9,
            'name' => 'Casa da Capoeira',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'extraFields' => [
                'type' => 'Centro de Capoeira',
                'description' => 'A Casa da Capoeira é um espaço onde são realizadas aulas, rodas de capoeira e eventos culturais ligados à arte e história da capoeira.',
                'location' => 'Rua da Luta, 432 – Fortaleza/CE – CEP: 60123-432',
                'accessibility' => ['Banheiros adaptados', 'Rampas de acesso'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_4,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
            ],
            'tags' => [
                TagFixtures::TAG_ID_10,
            ],
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::SPACE_ID_10,
            'name' => 'Dragão do Mar',
            'image' => null,
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'extraFields' => [
                'type' => 'Complexo Cultural',
                'description' => 'O Dragão do Mar é um dos maiores complexos culturais da região, com teatros, cinemas e galerias de arte que promovem a cultura local e internacional.',
                'location' => 'Rua do Dragão, 987 – Fortaleza/CE – CEP: 60123-111',
                'accessibility' => ['Banheiros adaptados', 'Rampas de acesso', 'Elevador adaptado'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_5,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
            ],
            'tags' => [
                TagFixtures::TAG_ID_2,
                TagFixtures::TAG_ID_9,
            ],
            'createdAt' => '2024-08-14T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public const array SPACES_UPDATED = [
        [
            'id' => self::SPACE_ID_1,
            'name' => 'SECULT',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'extraFields' => [
                'type' => 'Instituição Cultural',
                'description' => 'A Secretaria da Cultura (SECULT) é responsável por fomentar a arte e a cultura no estado, organizando eventos e oferecendo apoio a iniciativas locais.',
                'location' => 'Complexo Estação das Artes - R. Dr. João Moreira, 540 - Centro, Fortaleza - CE, 60030-000',
                'accessibility' => ['Banheiros adaptados', 'Rampa de acesso', 'Elevador adaptado', 'Sinalização tátil'],
            ],
            'activityAreas' => [
                ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                ActivityAreaFixtures::ACTIVITY_AREA_ID_10,
            ],
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
            ActivityAreaFixtures::class,
            TagFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->truncateTable(Space::class);
        $this->createSpaces($manager);
        $this->updateSpaces($manager);
        $this->manualLogout();
    }

    private function createSpaces(ObjectManager $manager): void
    {
        $counter = 0;

        foreach (self::SPACES as $spaceData) {
            if (5 > $counter) {
                $file = $this->fileService->uploadImage($this->parameterBag->get('app.dir.space.profile'), ImageTestFixtures::getSpaceImage());
                $spaceData['image'] = $file;
            }

            $space = $this->mountSpace($spaceData);

            $this->manualLoginByAgent($spaceData['createdBy']);

            $this->setReference(sprintf('%s-%s', self::SPACE_ID_PREFIX, $spaceData['id']), $space);

            $manager->persist($space);
            $counter++;
        }

        $manager->flush();
    }

    private function updateSpaces(ObjectManager $manager): void
    {
        foreach (self::SPACES_UPDATED as $spaceData) {
            $spaceObj = $this->getReference(sprintf('%s-%s', self::SPACE_ID_PREFIX, $spaceData['id']), Space::class);

            $space = $this->mountSpace($spaceData, ['object_to_populate' => $spaceObj]);

            $this->manualLoginByAgent($spaceData['createdBy']);

            $manager->persist($space);
        }

        $manager->flush();
    }

    private function mountSpace(mixed $spaceData, array $context = []): Space
    {
        /** @var Space $space */
        $space = $this->serializer->denormalize($spaceData, Space::class, context: $context);

        $space->setCreatedBy($this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $spaceData['createdBy'])));

        if (null !== $spaceData['parent']) {
            $parent = $this->getReference(sprintf('%s-%s', self::SPACE_ID_PREFIX, $spaceData['parent']));
            $space->setParent($parent);
        }

        return $space;
    }
}

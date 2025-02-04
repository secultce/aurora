<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\ActivityAreaFixtures;
use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\DataFixtures\Entity\TagFixtures;
use App\Entity\Space;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\ImageTestFixtures;
use App\Tests\Fixtures\SpaceTestFixtures;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class SpaceApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/spaces';

    private ?ParameterBagInterface $parameterBag = null;

    protected function setUp(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $this->parameterBag = $container->get(ParameterBagInterface::class);
    }

    public function testCanCreateWithPartialRequestBody(): void
    {
        $requestBody = SpaceTestFixtures::partial();

        $client = static::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        /** @var Space $space */
        $space = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'image' => null,
            'address' => null,
            'createdBy' => ['id' => $requestBody['createdBy']],
            'parent' => [
                'id' => $requestBody['parent'],
                'name' => 'SECULT',
                'image' => $space->getParent()->getImage(),
                'address' => $space->getParent()->getAddress(),
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'extraFields' => [
                    'type' => 'Instituição Cultural',
                    'description' => 'A Secretaria da Cultura (SECULT) é responsável por fomentar a arte e a cultura no estado, organizando eventos e oferecendo apoio a iniciativas locais.',
                    'location' => 'Complexo Estação das Artes - R. Dr. João Moreira, 540 - Centro, Fortaleza - CE, 60030-000',
                    'accessibility' => [
                        0 => 'Banheiros adaptados',
                        1 => 'Rampa de acesso',
                        2 => 'Elevador adaptado',
                        3 => 'Sinalização tátil',
                    ],
                ],
                'activityAreas' => [
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                        'name' => 'Música',
                    ],
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                        'name' => 'Teatro',
                    ],
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_10,
                        'name' => 'Fotografia',
                    ],
                ],
                'tags' => [
                    [
                        'id' => TagFixtures::TAG_ID_1,
                        'name' => 'Cultura',
                    ],
                    [
                        'id' => TagFixtures::TAG_ID_2,
                        'name' => 'Tecnologia',
                    ],
                ],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
                'deletedAt' => null,
            ],
            'extraFields' => null,
            'activityAreas' => [],
            'tags' => [],
            'createdAt' => $space->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testCanCreateWithCompleteRequestBody(): void
    {
        $requestBody = SpaceTestFixtures::complete();

        $client = static::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        /** @var Space $space */
        $space = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'image' => $space->getImage(),
            'address' => $space->getAddress(),
            'createdBy' => ['id' => $requestBody['createdBy']],
            'parent' => [
                'id' => $requestBody['parent'],
                'name' => 'SECULT',
                'image' => $space->getParent()->getImage(),
                'address' => $space->getParent()->getAddress(),
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'extraFields' => [
                    'type' => 'Instituição Cultural',
                    'description' => 'A Secretaria da Cultura (SECULT) é responsável por fomentar a arte e a cultura no estado, organizando eventos e oferecendo apoio a iniciativas locais.',
                    'location' => 'Complexo Estação das Artes - R. Dr. João Moreira, 540 - Centro, Fortaleza - CE, 60030-000',
                    'accessibility' => [
                        0 => 'Banheiros adaptados',
                        1 => 'Rampa de acesso',
                        2 => 'Elevador adaptado',
                        3 => 'Sinalização tátil',
                    ],
                ],
                'activityAreas' => [
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                        'name' => 'Música',
                    ],
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                        'name' => 'Teatro',
                    ],
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_10,
                        'name' => 'Fotografia',
                    ],
                ],
                'tags' => [
                    [
                        'id' => TagFixtures::TAG_ID_1,
                        'name' => 'Cultura',
                    ],
                    [
                        'id' => TagFixtures::TAG_ID_2,
                        'name' => 'Tecnologia',
                    ],
                ],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
                'deletedAt' => null,
            ],
            'extraFields' => [
                'type' => 'Cultural',
                'description' => 'É um espaço cultural que reúne artesãos de todo o Brasil para celebrar a cultura nordestina.',
                'location' => 'Recife, Pernambuco',
                'capacity' => 100,
                'accessibility' => [
                    0 => 'Banheiros adaptados',
                    1 => 'Rampa de acesso',
                    2 => 'Elevador adaptado',
                    3 => 'Sinalização tátil',
                ],
            ],
            'activityAreas' => [
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                    'name' => 'Artes Visuais',
                ],
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                    'name' => 'Música',
                ],
            ],
            'tags' => [],
            'createdAt' => $space->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationCreateCases')]
    public function testValidationCreate(array $requestBody, array $expectedErrors): void
    {
        $client = static::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationCreateCases(): array
    {
        $requestBody = SpaceTestFixtures::partial();

        return [
            'missing required fields' => [
                'requestBody' => [],
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value should not be blank.'],
                    ['field' => 'name', 'message' => 'This value should not be blank.'],
                    ['field' => 'createdBy', 'message' => 'This value should not be blank.'],
                ],
            ],
            'id is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['id' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'name is not a string' => [
                'requestBody' => array_merge($requestBody, ['name' => 123]),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value should be of type string.'],
                ],
            ],
            'name is too short' => [
                'requestBody' => array_merge($requestBody, ['name' => 'a']),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value is too short. It should have 2 characters or more.'],
                ],
            ],
            'name is too long' => [
                'requestBody' => array_merge($requestBody, ['name' => str_repeat('a', 101)]),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value is too long. It should have 100 characters or less.'],
                ],
            ],
            'createdBy should exist' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This id does not exist.'],
                ],
            ],
            'parent should exist' => [
                'requestBody' => array_merge($requestBody, ['parent' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'parent', 'message' => 'This id does not exist.'],
                ],
            ],
            'extraFields should be a valid JSON' => [
                'requestBody' => array_merge($requestBody, ['extraFields' => 'invalid-json']),
                'expectedErrors' => [
                    ['field' => 'extraFields', 'message' => 'This value should be of type json object.'],
                ],
            ],
        ];
    }

    public function testGet(): void
    {
        $client = static::apiClient();

        $client->request(Request::METHOD_GET, self::BASE_URL);
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(count(SpaceFixtures::SPACES), json_decode($response));

        /** @var Space $space */
        $space = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, SpaceFixtures::SPACE_ID_1);

        $this->assertJsonContains([
            'id' => SpaceFixtures::SPACE_ID_1,
            'name' => 'SECULT',
            'image' => $space->getImage(),
            'address' => null,
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'parent' => null,
            'activityAreas' => [
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                    'name' => 'Música',
                ],
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                    'name' => 'Teatro',
                ],
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_10,
                    'name' => 'Fotografia',
                ],
            ],
            'tags' => [
                [
                    'id' => TagFixtures::TAG_ID_1,
                    'name' => 'Cultura',
                ],
                [
                    'id' => TagFixtures::TAG_ID_2,
                    'name' => 'Tecnologia',
                ],
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => '2024-07-10T12:20:00+00:00',
            'deletedAt' => null,
        ]);
    }

    public function testGetItem(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, SpaceFixtures::SPACE_ID_3);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        /* @var Space $space */
        $space = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, SpaceFixtures::SPACE_ID_3);

        $this->assertResponseBodySame([
            'id' => '608756eb-4830-49f2-ae14-1160ca5252f4',
            'name' => 'Galeria Caatinga',
            'image' => $space->getImage(),
            'address' => null,
            'createdBy' => [
                'id' => '84a5b3d1-a7a4-49a6-aff8-902a325f97f9',
            ],
            'parent' => [
                'id' => 'ae32b8a5-25a8-4b80-b415-4237a8484186',
                'name' => 'Sítio das Artes',
                'image' => $space->getParent()->getImage(),
                'address' => [
                    'id' => 'b8636a9e-3906-4751-b4a9-7a24995813aa',
                    'street' => 'Avenida das Oliveiras',
                    'number' => 'S/N',
                    'neighborhood' => 'Jardins',
                    'complement' => null,
                    'city' => [],
                    'zipcode' => '60300100',
                ],
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => null,
                'extraFields' => [
                    'type' => 'Centro Cultural',
                    'description' => 'O Sítio das Artes é um espaço dedicado à promoção de atividades culturais e oficinas artísticas, com uma vasta programação para todas as idades.',
                    'location' => 'Av. das Artes, 123 – Fortaleza/CE – CEP: 60123-123',
                    'accessibility' => [
                        0 => 'Banheiros adaptados',
                        1 => 'Rampa de acesso',
                    ],
                ],
                'activityAreas' => [
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                        'name' => 'Artes Visuais',
                    ],
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                        'name' => 'Música',
                    ],
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_4,
                        'name' => 'Dança',
                    ],
                ],
                'tags' => [
                    [
                        'id' => TagFixtures::TAG_ID_3,
                        'name' => 'Sustentabilidade',
                    ],
                    [
                        'id' => TagFixtures::TAG_ID_4,
                        'name' => 'Social',
                    ],
                ],
                'createdAt' => '2024-07-11T10:49:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'extraFields' => [
                'type' => 'Galeria de Arte',
                'description' => 'A Galeria Caatinga é especializada em exposições de artistas regionais, com foco na arte nordestina e obras inspiradas pela fauna e flora do sertão.',
                'location' => 'Rua do Sertão, 123 – Fortaleza/CE – CEP: 60123-456',
                'accessibility' => [
                    0 => 'Elevador adaptado',
                    1 => 'Sinalização tátil',
                    2 => 'Banheiros acessíveis',
                ],
            ],
            'activityAreas' => [
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                    'name' => 'Artes Visuais',
                ],
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                    'name' => 'Música',
                ],
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_10,
                    'name' => 'Fotografia',
                ],
            ],
            'tags' => [
                [
                    'id' => TagFixtures::TAG_ID_5,
                    'name' => 'Educação',
                ],
                [
                    'id' => TagFixtures::TAG_ID_6,
                    'name' => 'Tradição',
                ],
            ],
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testGetAResourceWhenNotFound(): void
    {
        $client = static::apiClient();

        $client->request(Request::METHOD_GET, sprintf('%s/%s', self::BASE_URL, Uuid::v4()->toRfc4122()));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertResponseBodySame([
            'error_message' => 'not_found',
            'error_details' => [
                'description' => 'The requested Space was not found.',
            ],
        ]);
    }

    public function testDeleteAResourceWhenNotFound(): void
    {
        $client = static::apiClient();

        $client->request(Request::METHOD_DELETE, sprintf('%s/%s', self::BASE_URL, Uuid::v4()->toRfc4122()));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertResponseBodySame([
            'error_message' => 'not_found',
            'error_details' => [
                'description' => 'The requested Space was not found.',
            ],
        ]);
    }

    public function testDeleteASpaceItemWithSuccess(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, SpaceFixtures::SPACE_ID_3);

        $client->request(Request::METHOD_DELETE, $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $client->request(Request::METHOD_GET, $url);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testCanUpdate(): void
    {
        $requestBody = SpaceTestFixtures::complete();
        unset($requestBody['id']);
        unset($requestBody['image']);

        $url = sprintf('%s/%s', self::BASE_URL, SpaceFixtures::SPACE_ID_4);
        $client = self::apiClient();

        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        /** @var Space $space */
        $space = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, SpaceFixtures::SPACE_ID_4);

        $this->assertResponseBodySame([
            'id' => SpaceFixtures::SPACE_ID_4,
            'name' => $requestBody['name'],
            'image' => $space->getImage(),
            'address' => [
                'id' => 'fd64752a-c7ed-44ff-b092-44076dea4b4c',
                'street' => 'Avenida Central',
                'number' => '456',
                'neighborhood' => 'Centro',
                'complement' => 'Sala 302',
                'city' => [],
                'zipcode' => '30003210',
            ],
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'parent' => [
                'id' => SpaceFixtures::SPACE_ID_1,
                'name' => 'SECULT',
                'image' => $space->getParent()->getImage(),
                'address' => null,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_1,
                ],
                'extraFields' => [
                    'type' => 'Instituição Cultural',
                    'description' => 'A Secretaria da Cultura (SECULT) é responsável por fomentar a arte e a cultura no estado, organizando eventos e oferecendo apoio a iniciativas locais.',
                    'location' => 'Complexo Estação das Artes - R. Dr. João Moreira, 540 - Centro, Fortaleza - CE, 60030-000',
                    'accessibility' => [
                        0 => 'Banheiros adaptados',
                        1 => 'Rampa de acesso',
                        2 => 'Elevador adaptado',
                        3 => 'Sinalização tátil',
                    ],
                ],
                'activityAreas' => [
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                        'name' => 'Música',
                    ],
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                        'name' => 'Teatro',
                    ],
                    [
                        'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_10,
                        'name' => 'Fotografia',
                    ],
                ],
                'tags' => [
                    [
                        'id' => TagFixtures::TAG_ID_1,
                        'name' => 'Cultura',
                    ],
                    [
                        'id' => TagFixtures::TAG_ID_2,
                        'name' => 'Tecnologia',
                    ],
                ],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
                'deletedAt' => null,
            ],
            'extraFields' => [
                'type' => 'Cultural',
                'description' => 'É um espaço cultural que reúne artesãos de todo o Brasil para celebrar a cultura nordestina.',
                'location' => 'Recife, Pernambuco',
                'capacity' => 100,
                'accessibility' => [
                    0 => 'Banheiros adaptados',
                    1 => 'Rampa de acesso',
                    2 => 'Elevador adaptado',
                    3 => 'Sinalização tátil',
                ],
            ],
            'activityAreas' => [
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_1,
                    'name' => 'Artes Visuais',
                ],
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                    'name' => 'Música',
                ],
            ],
            'tags' => [
                [
                    'id' => TagFixtures::TAG_ID_7,
                    'name' => 'Juventude',
                ],
                [
                    'id' => TagFixtures::TAG_ID_8,
                    'name' => 'Oficina',
                ],
            ],
            'createdAt' => $space->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $space->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);
    }

    public function testCanUpdateImageWithMultipartFormData(): void
    {
        $file = ImageTestFixtures::getImageValid();

        $url = sprintf('%s/%s/images', self::BASE_URL, SpaceFixtures::SPACE_ID_1);

        $client = self::apiClient();
        $client->request(
            Request::METHOD_POST,
            $url,
            files: ['image' => $file],
            server: [
                'CONTENT_TYPE' => 'multipart/form-data',
            ]
        );

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        /* @var Space $space */
        $space = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, SpaceFixtures::SPACE_ID_1);

        $this->assertResponseBodySame([
            'id' => SpaceFixtures::SPACE_ID_1,
            'name' => 'SECULT',
            'image' => $space->getImage(),
            'address' => null,
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'parent' => null,
            'extraFields' => [
                'type' => 'Instituição Cultural',
                'description' => 'A Secretaria da Cultura (SECULT) é responsável por fomentar a arte e a cultura no estado, organizando eventos e oferecendo apoio a iniciativas locais.',
                'location' => 'Complexo Estação das Artes - R. Dr. João Moreira, 540 - Centro, Fortaleza - CE, 60030-000',
                'accessibility' => [
                    0 => 'Banheiros adaptados',
                    1 => 'Rampa de acesso',
                    2 => 'Elevador adaptado',
                    3 => 'Sinalização tátil',
                ],
            ],
            'activityAreas' => [
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_2,
                    'name' => 'Música',
                ],
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_3,
                    'name' => 'Teatro',
                ],
                [
                    'id' => ActivityAreaFixtures::ACTIVITY_AREA_ID_10,
                    'name' => 'Fotografia',
                ],
            ],
            'tags' => [
                [
                    'id' => TagFixtures::TAG_ID_1,
                    'name' => 'Cultura',
                ],
                [
                    'id' => TagFixtures::TAG_ID_2,
                    'name' => 'Tecnologia',
                ],
            ],
            'createdAt' => $space->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $space->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationUpdateCases')]
    public function testValidationUpdate(array $requestBody, array $expectedErrors): void
    {
        $client = self::apiClient();
        $url = sprintf('%s/%s', self::BASE_URL, SpaceFixtures::SPACE_ID_3);
        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationUpdateCases(): array
    {
        $requestBody = SpaceTestFixtures::partial();

        return [
            'name should be string' => [
                'requestBody' => array_merge($requestBody, ['name' => 123]),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value should be of type string.'],
                ],
            ],
            'name too short' => [
                'requestBody' => array_merge($requestBody, ['name' => 'a']),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value is too short. It should have 2 characters or more.'],
                ],
            ],
            'name too long' => [
                'requestBody' => array_merge($requestBody, ['name' => str_repeat('a', 101)]),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value is too long. It should have 100 characters or less.'],
                ],
            ],
            'parent should exists' => [
                'requestBody' => array_merge($requestBody, ['parent' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'parent', 'message' => 'This id does not exist.'],
                ],
            ],
            'createdBy should exists' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This id does not exist.'],
                ],
            ],
            'extraFields should be a valid JSON' => [
                'requestBody' => array_merge($requestBody, ['extraFields' => 'invalid-json']),
                'expectedErrors' => [
                    ['field' => 'extraFields', 'message' => 'This value should be of type json object.'],
                ],
            ],
        ];
    }

    #[DataProvider('provideValidationUpdateImageCases')]
    public function testValidationUpdateImage(array $requestBody, $file, array $expectedErrors): void
    {
        $url = sprintf('%s/%s/images', self::BASE_URL, SpaceFixtures::SPACE_ID_1);

        $client = self::apiClient();
        $client->request(
            Request::METHOD_POST,
            $url,
            files: ['image' => $file],
            server: [
                'CONTENT_TYPE' => 'multipart/form-data',
            ]
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationUpdateImageCases(): array
    {
        $requestBody = SpaceTestFixtures::partial();
        unset($requestBody['id']);

        return [
            'image not supported' => [
                'requestBody' => $requestBody,
                'file' => ImageTestFixtures::getGif(),
                'expectedErrors' => [
                    ['field' => 'image', 'message' => 'The mime type of the file is invalid ("image/gif"). Allowed mime types are "image/png", "image/jpg", "image/jpeg".'],
                ],
            ],
            'image size' => [
                'requestBody' => $requestBody,
                'file' => ImageTestFixtures::getImageMoreThan2mb(),
                'expectedErrors' => [
                    ['field' => 'image', 'message' => 'The file is too large (2.5 MB). Allowed maximum size is 2 MB.'],
                ],
            ],
        ];
    }
}

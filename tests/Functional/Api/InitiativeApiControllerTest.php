<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\InitiativeFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\Entity\Initiative;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\InitiativeTestFixtures;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class InitiativeApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/initiatives';

    public function testGet(): void
    {
        $client = static::apiClient();

        $client->request(Request::METHOD_GET, self::BASE_URL);
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(count(InitiativeFixtures::INITIATIVES), json_decode($response));

        $this->assertJsonContains([
            'id' => InitiativeFixtures::INITIATIVE_ID_1,
            'name' => 'Vozes do Sertão',
            'parent' => null,
            'space' => [
                'id' => SpaceFixtures::SPACE_ID_4,
            ],
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => '2024-07-10T12:20:00+00:00',
            'deletedAt' => null,
        ]);
    }

    public function testGetAnInitiativeItemWithSuccess(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, InitiativeFixtures::INITIATIVE_ID_1);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseBodySame([
            'id' => InitiativeFixtures::INITIATIVE_ID_1,
            'name' => 'Vozes do Sertão',
            'parent' => null,
            'space' => [
                'id' => SpaceFixtures::SPACE_ID_4,
            ],
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'extraFields' => [
                'culturalLanguage' => 'Musical',
                'period' => [
                    'startDate' => '2024-08-01',
                    'endDate' => '2024-08-31',
                ],
                'shortDescription' => 'Vozes do Sertão é um festival de música que reúne artistas de todo o Brasil para celebrar a cultura nordestina.',
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => '2024-07-10T12:20:00+00:00',
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
                'description' => 'The requested Initiative was not found.',
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
                'description' => 'The requested Initiative was not found.',
            ],
        ]);
    }

    public function testDeleteAnInitiativeItemWithSuccess(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, InitiativeFixtures::INITIATIVE_ID_4);

        $client->request(Request::METHOD_DELETE, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function testCanCreateWithPartialRequestBody(): void
    {
        $requestBody = InitiativeTestFixtures::partial();

        $client = self::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $initiative = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Initiative::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'parent' => null,
            'space' => null,
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'extraFields' => null,
            'createdAt' => $initiative->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testCanCreateWithCompleteRequestBody(): void
    {
        $requestBody = InitiativeTestFixtures::complete();

        $client = self::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $initiative = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Initiative::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'parent' => [
                'id' => $requestBody['parent'],
                'name' => 'Raízes e Tradições',
                'space' => null,
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'extraFields' => [
                    'culturalLanguage' => 'Cultural',
                    'period' => [
                        'startDate' => '2024-08-15',
                        'endDate' => '2024-09-15',
                    ],
                    'shortDescription' => 'Raízes e Tradições é uma exposição que reúne artesãos de todo o Brasil para celebrar a cultura nordestina.',
                ],
                'createdAt' => '2024-07-11T10:49:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'space' => [
                'id' => $requestBody['space'],
            ],
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'extraFields' => $requestBody['extraFields'],
            'createdAt' => $initiative->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationCreateCases')]
    public function testValidationCreate(array $requestBody, string $detail, array $violations): void
    {
        $client = static::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertResponseBodySame([
            'type' => 'https://symfony.com/errors/validation',
            'title' => 'Validation Failed',
            'detail' => $detail,
            'violations' => $violations,
        ]);
    }

    public static function provideValidationCreateCases(): array
    {
        $requestBody = InitiativeTestFixtures::partial();

        return [
            'missing required fields' => [
                'requestBody' => [],
                'detail' => "id: This value should not be blank.\nname: This value should not be blank.\ncreatedBy: This value should not be blank.",
                'violations' => [
                    [
                        'propertyPath' => 'id',
                        'title' => 'This value should not be blank.',
                        'template' => 'This value should not be blank.',
                        'parameters' => ['{{ value }}' => 'null'],
                        'type' => 'urn:uuid:c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                    ],
                    [
                        'propertyPath' => 'name',
                        'title' => 'This value should not be blank.',
                        'template' => 'This value should not be blank.',
                        'parameters' => ['{{ value }}' => 'null'],
                        'type' => 'urn:uuid:c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                    ],
                    [
                        'propertyPath' => 'createdBy',
                        'title' => 'This value should not be blank.',
                        'template' => 'This value should not be blank.',
                        'parameters' => ['{{ value }}' => 'null'],
                        'type' => 'urn:uuid:c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                    ],
                ],
            ],
            'id is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['id' => 'invalid-uuid']),
                'detail' => 'id: This value is not a valid UUID.',
                'violations' => [
                    [
                        'propertyPath' => 'id',
                        'title' => 'This value is not a valid UUID.',
                        'template' => 'This is not a valid UUID.',
                        'parameters' => ['{{ value }}' => '"invalid-uuid"'],
                        'type' => 'urn:uuid:51120b12-a2bc-41bf-aa53-cd73daf330d0',
                    ],
                ],
            ],
            'name is not a string' => [
                'requestBody' => array_merge($requestBody, ['name' => 123]),
                'detail' => 'name: This value should be of type string.',
                'violations' => [
                    [
                        'propertyPath' => 'name',
                        'title' => 'This value should be of type string.',
                        'template' => 'This value should be of type {{ type }}.',
                        'parameters' => [
                            '{{ value }}' => '123',
                            '{{ type }}' => 'string',
                        ],
                        'type' => 'urn:uuid:ba785a8c-82cb-4283-967c-3cf342181b40',
                    ],
                ],
            ],
            'name is too short' => [
                'requestBody' => array_merge($requestBody, ['name' => 'a']),
                'detail' => 'name: This value is too short. It should have 2 characters or more.',
                'violations' => [
                    [
                        'propertyPath' => 'name',
                        'title' => 'This value is too short. It should have 2 characters or more.',
                        'template' => 'This value is too short. It should have {{ limit }} character or more.|This value is too short. It should have {{ limit }} characters or more.',
                        'parameters' => [
                            '{{ value }}' => '"a"',
                            '{{ limit }}' => '2',
                            '{{ value_length }}' => '1',
                        ],
                        'type' => 'urn:uuid:9ff3fdc4-b214-49db-8718-39c315e33d45',
                    ],
                ],
            ],
            'name is too long' => [
                'requestBody' => array_merge($requestBody, ['name' => str_repeat('a', 101)]),
                'detail' => 'name: This value is too long. It should have 100 characters or less.',
                'violations' => [
                    [
                        'propertyPath' => 'name',
                        'title' => 'This value is too long. It should have 100 characters or less.',
                        'template' => 'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.',
                        'parameters' => [
                            '{{ value }}' => '"'.str_repeat('a', 101).'"',
                            '{{ limit }}' => '100',
                            '{{ value_length }}' => '101',
                        ],
                        'type' => 'urn:uuid:d94b19cc-114f-4f44-9cc4-4138e80a87b9',
                    ],
                ],
            ],
            'createdBy should exist' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => Uuid::v4()->toRfc4122()]),
                'detail' => 'createdBy: This id does not exist.',
                'violations' => [
                    [
                        'propertyPath' => 'createdBy',
                        'title' => 'This id does not exist.',
                        'template' => 'This id does not exist.',
                        'parameters' => [],
                    ],
                ],
            ],
            'createdBy is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => 'invalid-uuid']),
                'detail' => 'createdBy: This value is not a valid UUID.',
                'violations' => [
                    [
                        'propertyPath' => 'createdBy',
                        'title' => 'This value is not a valid UUID.',
                        'template' => 'This is not a valid UUID.',
                        'parameters' => ['{{ value }}' => '"invalid-uuid"'],
                        'type' => 'urn:uuid:51120b12-a2bc-41bf-aa53-cd73daf330d0',
                    ],
                ],
            ],
            'parent should exist' => [
                'requestBody' => array_merge($requestBody, ['parent' => Uuid::v4()->toRfc4122()]),
                'detail' => 'parent: This id does not exist.',
                'violations' => [
                    [
                        'propertyPath' => 'parent',
                        'title' => 'This id does not exist.',
                        'template' => 'This id does not exist.',
                        'parameters' => [],
                    ],
                ],
            ],
            'parent is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['parent' => 'invalid-uuid']),
                'detail' => 'parent: This value is not a valid UUID.',
                'violations' => [
                    [
                        'propertyPath' => 'parent',
                        'title' => 'This value is not a valid UUID.',
                        'template' => 'This is not a valid UUID.',
                        'parameters' => ['{{ value }}' => '"invalid-uuid"'],
                        'type' => 'urn:uuid:51120b12-a2bc-41bf-aa53-cd73daf330d0',
                    ],
                ],
            ],
            'space should exist' => [
                'requestBody' => array_merge($requestBody, ['space' => Uuid::v4()->toRfc4122()]),
                'detail' => 'space: This id does not exist.',
                'violations' => [
                    [
                        'propertyPath' => 'space',
                        'title' => 'This id does not exist.',
                        'template' => 'This id does not exist.',
                        'parameters' => [],
                    ],
                ],
            ],
            'space is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['space' => 'invalid-uuid']),
                'detail' => 'space: This value is not a valid UUID.',
                'violations' => [
                    [
                        'propertyPath' => 'space',
                        'title' => 'This value is not a valid UUID.',
                        'template' => 'This is not a valid UUID.',
                        'parameters' => ['{{ value }}' => '"invalid-uuid"'],
                        'type' => 'urn:uuid:51120b12-a2bc-41bf-aa53-cd73daf330d0',
                    ],
                ],
            ],
            'extraFields should be a valid JSON' => [
                'requestBody' => array_merge($requestBody, ['extraFields' => 'invalid-json']),
                'detail' => 'extraFields: This value should be of type json object.',
                'violations' => [
                    [
                        'propertyPath' => 'extraFields',
                        'title' => 'This value should be of type json object.',
                        'template' => 'This value should be of type {{ type }}.',
                        'parameters' => ['{{ type }}' => 'json object'],
                    ],
                ],
            ],
        ];
    }

    public function testCanUpdate(): void
    {
        $requestBody = InitiativeTestFixtures::complete();
        unset($requestBody['id']);

        $url = sprintf('%s/%s', self::BASE_URL, InitiativeFixtures::INITIATIVE_ID_8);

        $client = self::apiClient();

        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $initiative = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Initiative::class, InitiativeFixtures::INITIATIVE_ID_8);

        $this->assertResponseBodySame([
            'id' => InitiativeFixtures::INITIATIVE_ID_8,
            'name' => $requestBody['name'],
            'parent' => [
                'id' => InitiativeFixtures::INITIATIVE_ID_2,
                'name' => 'Raízes e Tradições',
                'space' => null,
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'extraFields' => [
                    'culturalLanguage' => 'Cultural',
                    'period' => [
                        'startDate' => '2024-08-15',
                        'endDate' => '2024-09-15',
                    ],
                    'shortDescription' => 'Raízes e Tradições é uma exposição que reúne artesãos de todo o Brasil para celebrar a cultura nordestina.',
                ],
                'createdAt' => '2024-07-11T10:49:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'space' => [
                'id' => SpaceFixtures::SPACE_ID_4,
            ],
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'extraFields' => $requestBody['extraFields'],
            'createdAt' => $initiative->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $initiative->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationUpdateCases')]
    public function testValidationUpdate(array $requestBody, array $expectedErrors): void
    {
        $client = self::apiClient();
        $url = sprintf('%s/%s', self::BASE_URL, InitiativeFixtures::INITIATIVE_ID_8);
        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationUpdateCases(): array
    {
        $requestBody = InitiativeTestFixtures::partial();

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
            'parent is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['parent' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'parent', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'createdBy should exists' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This id does not exist.'],
                ],
            ],
            'createdBy is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'space should exists' => [
                'requestBody' => array_merge($requestBody, ['space' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'space', 'message' => 'This id does not exist.'],
                ],
            ],
            'space is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['space' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'space', 'message' => 'This value is not a valid UUID.'],
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
}

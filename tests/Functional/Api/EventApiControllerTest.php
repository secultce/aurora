<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\EventFixtures;
use App\DataFixtures\Entity\InitiativeFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\Entity\Event;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\EventTestFixtures;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class EventApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/events';

    public function testCanCreateWithPartialRequestBody(): void
    {
        $client = static::apiClient();

        $requestBody = EventTestFixtures::partial();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $event = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Event::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'agentGroup' => ['id' => AgentFixtures::AGENT_ID_1],
            'space' => ['id' => SpaceFixtures::SPACE_ID_1],
            'initiative' => ['id' => InitiativeFixtures::INITIATIVE_ID_1],
            'parent' => null,
            'extraFields' => null,
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'createdAt' => $event->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testCanCreateWithCompleteRequestBody(): void
    {
        $client = static::apiClient();

        $requestBody = EventTestFixtures::complete();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $event = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Event::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'agentGroup' => ['id' => AgentFixtures::AGENT_ID_1],
            'space' => ['id' => SpaceFixtures::SPACE_ID_1],
            'initiative' => ['id' => InitiativeFixtures::INITIATIVE_ID_1],
            'parent' => [
                'id' => EventFixtures::EVENT_ID_1,
                'name' => 'Festival Sertão Criativo',
                'agentGroup' => null,
                'space' => ['id' => SpaceFixtures::SPACE_ID_3],
                'initiative' => ['id' => InitiativeFixtures::INITIATIVE_ID_2],
                'parent' => null,
                'extraFields' => null,
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T11:35:00+00:00',
                'deletedAt' => null,
            ],
            'extraFields' => [
                'occurrences' => [
                    '2025-01-16T09:45:00-03:00',
                    '2025-02-13T09:45:00-03:00',
                    '2025-03-13T09:45:00-03:00',
                ],
                'description' => 'Test Event Description',
                'locationDescription' => 'Test Event Location',
                'instagram' => '@mytestevent',
            ],
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'createdAt' => $event->getCreatedAt()->format(DateTimeInterface::ATOM),
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
        $requestBody = EventTestFixtures::partial();

        return [
            'missing required fields' => [
                'requestBody' => [],
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value should not be blank.'],
                    ['field' => 'name', 'message' => 'This value should not be blank.'],
                    ['field' => 'agentGroup', 'message' => 'This value should not be blank.'],
                    ['field' => 'space', 'message' => 'This value should not be blank.'],
                    ['field' => 'initiative', 'message' => 'This value should not be blank.'],
                    ['field' => 'createdBy', 'message' => 'This value should not be blank.'],
                ],
            ],
            'id is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['id' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'name should be a string' => [
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
                'requestBody' => array_merge($requestBody, ['name' => str_repeat('a', 256)]),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value is too long. It should have 100 characters or less.'],
                ],
            ],
            'agentGroup is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['agentGroup' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'agentGroup', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'agentGroup should exist' => [
                'requestBody' => array_merge($requestBody, ['agentGroup' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'agentGroup', 'message' => 'This id does not exist.'],
                ],
            ],
            'space is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['space' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'space', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'space should exist' => [
                'requestBody' => array_merge($requestBody, ['space' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'space', 'message' => 'This id does not exist.'],
                ],
            ],
            'initiative is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['initiative' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'initiative', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'initiative should exist' => [
                'requestBody' => array_merge($requestBody, ['initiative' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'initiative', 'message' => 'This id does not exist.'],
                ],
            ],
            'parent is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['parent' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'parent', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'parent should exist' => [
                'requestBody' => array_merge($requestBody, ['parent' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'parent', 'message' => 'This id does not exist.'],
                ],
            ],
            'createdBy is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'createdBy should exist' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This id does not exist.'],
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
        $this->assertCount(count(EventFixtures::EVENTS), json_decode($response));

        $this->assertJsonContains([
            'id' => EventFixtures::EVENT_ID_1,
            'name' => 'Festival Sertão Criativo',
            'agentGroup' => null,
            'space' => [
                'id' => SpaceFixtures::SPACE_ID_3,
            ],
            'initiative' => [
                'id' => InitiativeFixtures::INITIATIVE_ID_2,
            ],
            'parent' => null,
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => '2024-07-10T11:35:00+00:00',
            'deletedAt' => null,
        ]);
    }

    public function testGetItem(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, EventFixtures::EVENT_ID_6);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseBodySame([
            'id' => '64f6d8a0-6326-4c15-bec1-d4531720f578',
            'name' => 'Cores do Sertão',
            'agentGroup' => null,
            'space' => [
                'id' => SpaceFixtures::SPACE_ID_3,
            ],
            'initiative' => [
                'id' => InitiativeFixtures::INITIATIVE_ID_10,
            ],
            'parent' => [
                'id' => EventFixtures::EVENT_ID_3,
                'name' => 'Músical o vento da Caatinga',
                'agentGroup' => null,
                'space' => [
                    'id' => SpaceFixtures::SPACE_ID_5,
                ],
                'initiative' => [
                    'id' => InitiativeFixtures::INITIATIVE_ID_7,
                ],
                'parent' => null,
                'extraFields' => null,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_2,
                ],
                'createdAt' => '2024-07-16T17:22:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'extraFields' => [
                'subtitle' => 'Cores do Sertão',
                'description' => 'Cores do Sertão',
                'occurrences' => ['2025-08-05T10:30:00-03:00'],
            ],
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_3,
            ],
            'createdAt' => '2024-08-10T11:26:00+00:00',
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
                'description' => 'The requested Event was not found.',
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
                'description' => 'The requested Event was not found.',
            ],
        ]);
    }

    public function testDeleteAnEventItemWithSuccess(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, EventFixtures::EVENT_ID_4);

        $client->request(Request::METHOD_DELETE, $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $client->request(Request::METHOD_GET, $url);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testCanUpdate(): void
    {
        $requestBody = EventTestFixtures::complete();
        unset($requestBody['id']);

        $url = sprintf('%s/%s', self::BASE_URL, EventFixtures::EVENT_ID_3);

        $client = self::apiClient();

        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $event = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Event::class, EventFixtures::EVENT_ID_3);

        $this->assertResponseBodySame([
            'id' => EventFixtures::EVENT_ID_3,
            'name' => 'Test Event',
            'agentGroup' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'space' => ['id' => SpaceFixtures::SPACE_ID_1],
            'initiative' => ['id' => InitiativeFixtures::INITIATIVE_ID_1],
            'parent' => [
                'id' => EventFixtures::EVENT_ID_1,
                'name' => 'Festival Sertão Criativo',
                'agentGroup' => null,
                'space' => ['id' => SpaceFixtures::SPACE_ID_3],
                'initiative' => ['id' => InitiativeFixtures::INITIATIVE_ID_2],
                'parent' => null,
                'extraFields' => null,
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T11:35:00+00:00',
                'deletedAt' => null,
            ],
            'extraFields' => $requestBody['extraFields'],
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'createdAt' => $event->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $event->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationUpdateCases')]
    public function testValidationUpdate(array $requestBody, array $expectedErrors): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, EventFixtures::EVENT_ID_4);
        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationUpdateCases(): array
    {
        $requestBody = EventTestFixtures::partial();

        return [
            'name should be a string' => [
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
                'requestBody' => array_merge($requestBody, ['name' => str_repeat('a', 256)]),
                'expectedErrors' => [
                    ['field' => 'name', 'message' => 'This value is too long. It should have 100 characters or less.'],
                ],
            ],
            'agentGroup is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['agentGroup' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'agentGroup', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'agentGroup should exist' => [
                'requestBody' => array_merge($requestBody, ['agentGroup' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'agentGroup', 'message' => 'This id does not exist.'],
                ],
            ],
            'space is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['space' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'space', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'space should exist' => [
                'requestBody' => array_merge($requestBody, ['space' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'space', 'message' => 'This id does not exist.'],
                ],
            ],
            'initiative is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['initiative' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'initiative', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'initiative should exist' => [
                'requestBody' => array_merge($requestBody, ['initiative' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'initiative', 'message' => 'This id does not exist.'],
                ],
            ],
            'parent is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['parent' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'parent', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'parent should exist' => [
                'requestBody' => array_merge($requestBody, ['parent' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'parent', 'message' => 'This id does not exist.'],
                ],
            ],
            'createdBy is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'createdBy should exist' => [
                'requestBody' => array_merge($requestBody, ['createdBy' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'createdBy', 'message' => 'This id does not exist.'],
                ],
            ],
            'extra fields should be a valid json object' => [
                'requestBody' => array_merge($requestBody, ['extraFields' => 'invalid']),
                'expectedErrors' => [
                    ['field' => 'extraFields', 'message' => 'This value should be of type json object.'],
                ],
            ],
        ];
    }
}

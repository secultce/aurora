<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\Entity\Space;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\SpaceTestFixtures;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class SpaceApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/spaces';

    public function testCanCreateWithPartialRequestBody(): void
    {
        $requestBody = SpaceTestFixtures::partial();

        $client = static::createClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, server: [
            'HTTP_ACCEPT' => 'application/json',
        ], content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $space = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'createdBy' => ['id' => $requestBody['createdBy']],
            'parent' => [
                'id' => $requestBody['parent'],
                'name' => 'SECULT',
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'createdAt' => $space->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testCanCreateWithCompleteRequestBody(): void
    {
        $requestBody = SpaceTestFixtures::complete();

        $client = static::createClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, server: [
            'HTTP_ACCEPT' => 'application/json',
        ], content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $space = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'createdBy' => ['id' => $requestBody['createdBy']],
            'parent' => [
                'id' => $requestBody['parent'],
                'name' => 'SECULT',
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'createdAt' => $space->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationCreateCases')]
    public function testValidationCreate(array $requestBody, array $expectedErrors): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, server: [
            'HTTP_ACCEPT' => 'application/json',
        ], content: json_encode($requestBody));

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
        ];
    }

    public function testGet(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, self::BASE_URL);
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(count(SpaceFixtures::SPACES), json_decode($response));

        $this->assertJsonContains([
            'id' => SpaceFixtures::SPACE_ID_1,
            'name' => 'SECULT',
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'parent' => null,
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testGetItem(): void
    {
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URL, SpaceFixtures::SPACE_ID_3);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseBodySame([
            'id' => '608756eb-4830-49f2-ae14-1160ca5252f4',
            'name' => 'Galeria Caatinga',
            'createdBy' => [
                'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
            ],
            'parent' => [
                'id' => 'ae32b8a5-25a8-4b80-b415-4237a8484186',
                'name' => 'Sítio das Artes',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => null,
                'createdAt' => '2024-07-11T10:49:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testGetAResourceWhenNotFound(): void
    {
        $client = static::createClient();

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
        $client = static::createClient();

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
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URL, SpaceFixtures::SPACE_ID_3);

        $client->request(Request::METHOD_DELETE, $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $client->request(Request::METHOD_GET, $url);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}

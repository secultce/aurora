<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
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
            'createdBy' => ['id' => $requestBody['createdBy']],
            'parent' => [
                'id' => $requestBody['parent'],
                'name' => 'SECULT',
                'image' => $space->getParent()->getImage(),
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
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
            'createdBy' => ['id' => $requestBody['createdBy']],
            'parent' => [
                'id' => $requestBody['parent'],
                'name' => 'SECULT',
                'image' => $space->getParent()->getImage(),
                'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
                'deletedAt' => null,
            ],
            'createdAt' => $space->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);

        $filepath = str_replace($this->parameterBag->get('app.url.storage'), '', $space->getImage());
        file_exists($filepath);
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
            'image not supported' => [
                'requestBody' => array_merge($requestBody, ['image' => ImageTestFixtures::getGif()]),
                'expectedErrors' => [
                    ['field' => 'image', 'message' => 'The mime type of the file is invalid ("image/gif"). Allowed mime types are "image/png", "image/jpg", "image/jpeg".'],
                ],
            ],
            'image size' => [
                'requestBody' => array_merge($requestBody, ['image' => ImageTestFixtures::getImageMoreThan2mb()]),
                'expectedErrors' => [
                    ['field' => 'image', 'message' => 'The file is too large (2.5 MB). Allowed maximum size is 2 MB.'],
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
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'parent' => null,
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
            'createdBy' => [
                'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
            ],
            'parent' => [
                'id' => 'ae32b8a5-25a8-4b80-b415-4237a8484186',
                'name' => 'Sítio das Artes',
                'image' => $space->getParent()->getImage(),
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
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'parent' => [
                'id' => SpaceFixtures::SPACE_ID_1,
                'name' => 'SECULT',
                'image' => $space->getParent()->getImage(),
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_1,
                ],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
                'deletedAt' => null,
            ],
            'createdAt' => $space->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $space->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);
    }

    public function testCanUpdateImage(): void
    {
        $requestBody = SpaceTestFixtures::complete();

        $client = self::apiClient();
        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        /** @var Space $createdSpace */
        $createdSpace = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'image' => $createdSpace->getImage(),
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'parent' => [
                'id' => SpaceFixtures::SPACE_ID_1,
                'name' => 'SECULT',
                'image' => $createdSpace->getParent()->getImage(),
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_1,
                ],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
                'deletedAt' => null,
            ],
            'createdAt' => $createdSpace->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);

        $firstImage = str_replace($this->parameterBag->get('app.url.storage'), '', $createdSpace->getImage());
        file_exists($firstImage);

        $url = sprintf('%s/%s', self::BASE_URL, $requestBody['id']);
        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $updatedSpace = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Space::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'image' => $updatedSpace->getImage(),
            'createdBy' => ['id' => AgentFixtures::AGENT_ID_1],
            'parent' => [
                'id' => SpaceFixtures::SPACE_ID_1,
                'name' => 'SECULT',
                'image' => $updatedSpace->getParent()->getImage(),
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_1,
                ],
                'parent' => null,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => '2024-07-10T12:20:00+00:00',
                'deletedAt' => null,
            ],
            'createdAt' => $updatedSpace->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $updatedSpace->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);

        self::assertFalse(file_exists($firstImage));

        $secondImage = str_replace($this->parameterBag->get('app.url.storage'), '', $updatedSpace->getImage());
        file_exists($secondImage);
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
            'image not supported' => [
                'requestBody' => array_merge($requestBody, ['image' => ImageTestFixtures::getGif()]),
                'expectedErrors' => [
                    ['field' => 'image', 'message' => 'The mime type of the file is invalid ("image/gif"). Allowed mime types are "image/png", "image/jpg", "image/jpeg".'],
                ],
            ],
            'image size' => [
                'requestBody' => array_merge($requestBody, ['image' => ImageTestFixtures::getImageMoreThan2mb()]),
                'expectedErrors' => [
                    ['field' => 'image', 'message' => 'The file is too large (2.5 MB). Allowed maximum size is 2 MB.'],
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
        ];
    }
}

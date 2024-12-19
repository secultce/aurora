<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\AddressFixtures;
use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\OrganizationFixtures;
use App\DataFixtures\Entity\UserFixtures;
use App\Entity\Agent;
use App\Tests\AbstractWebTestCase;
use App\Tests\Fixtures\AgentTestFixtures;
use App\Tests\Fixtures\ImageTestFixtures;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class AgentApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/agents';

    private ?ParameterBagInterface $parameterBag = null;

    protected function setUp(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $this->parameterBag = $container->get(ParameterBagInterface::class);
    }

    public function testCanCreateWithPartialRequestBody(): void
    {
        $requestBody = AgentTestFixtures::partial();

        $client = self::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $agent = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Agent::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'image' => null,
            'shortBio' => $requestBody['shortBio'],
            'longBio' => $requestBody['longBio'],
            'culture' => true,
            'main' => false,
            'extraFields' => null,
            'user' => ['id' => $requestBody['user']],
            'organizations' => [],
            'addresses' => null,
            'createdAt' => $agent->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testCanCreateWithCompleteRequestBody(): void
    {
        $requestBody = AgentTestFixtures::complete();

        $client = self::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        /* @var Agent $agent */
        $agent = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Agent::class, $requestBody['id']);

        $this->assertResponseBodySame([
            'id' => $requestBody['id'],
            'name' => $requestBody['name'],
            'image' => null,
            'shortBio' => $requestBody['shortBio'],
            'longBio' => $requestBody['longBio'],
            'culture' => $requestBody['culture'],
            'main' => $requestBody['main'],
            'extraFields' => [
                'site' => 'https://www.google.com/',
                'instagram' => '@test.agent',
                'facebook' => '@test.agent',
                'x' => '@test.agent',
            ],
            'user' => ['id' => $requestBody['user']],
            'organizations' => [
                ['id' => OrganizationFixtures::ORGANIZATION_ID_1],
            ],
            'addresses' => null,
            'createdAt' => $agent->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationCreateCases')]
    public function testValidationCreate(array $requestBody, array $expectedErrors): void
    {
        $client = self::apiClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationCreateCases(): array
    {
        $requestBody = AgentTestFixtures::partial();

        return [
            'missing required fields' => [
                'requestBody' => [],
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value should not be blank.'],
                    ['field' => 'name', 'message' => 'This value should not be blank.'],
                    ['field' => 'shortBio', 'message' => 'This value should not be blank.'],
                    ['field' => 'user', 'message' => 'This value should not be blank.'],
                ],
            ],
            'id is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['id' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'id', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
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
            'shortBio should be string' => [
                'requestBody' => array_merge($requestBody, ['shortBio' => 123]),
                'expectedErrors' => [
                    ['field' => 'shortBio', 'message' => 'This value should be of type string.'],
                ],
            ],
            'shortBio too long' => [
                'requestBody' => array_merge($requestBody, ['shortBio' => str_repeat('a', 256)]),
                'expectedErrors' => [
                    ['field' => 'shortBio', 'message' => 'This value is too long. It should have 100 characters or less.'],
                ],
            ],
            'longBio should be string' => [
                'requestBody' => array_merge($requestBody, ['longBio' => 123]),
                'expectedErrors' => [
                    ['field' => 'longBio', 'message' => 'This value should be of type string.'],
                ],
            ],
            'longBio too long' => [
                'requestBody' => array_merge($requestBody, ['longBio' => str_repeat('a', 256)]),
                'expectedErrors' => [
                    ['field' => 'longBio', 'message' => 'This value is too long. It should have 255 characters or less.'],
                ],
            ],
            'culture should be boolean' => [
                'requestBody' => array_merge($requestBody, ['culture' => 'invalid']),
                'expectedErrors' => [
                    ['field' => 'culture', 'message' => 'This value should be of type bool.'],
                ],
            ],
            'organizations should be an array' => [
                'requestBody' => array_merge($requestBody, ['organizations' => 'invalid']),
                'expectedErrors' => [
                    ['field' => 'organizations', 'message' => 'This value should be of type iterable.'],
                ],
            ],
            'organizations is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['organizations' => ['invalid-uuid']]),
                'expectedErrors' => [
                    ['field' => 'organizations[0]', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'organizations should exist' => [
                'requestBody' => array_merge($requestBody, ['organizations' => [Uuid::v4()->toRfc4122()]]),
                'expectedErrors' => [
                    ['field' => 'organizations[0]', 'message' => 'This id does not exist.'],
                ],
            ],
            'extraFields should be a valid JSON' => [
                'requestBody' => array_merge($requestBody, ['extraFields' => 'invalid-json']),
                'expectedErrors' => [
                    ['field' => 'extraFields', 'message' => 'This value should be of type json object.'],
                ],
            ],
            'user is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['user' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'user', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'user should exist' => [
                'requestBody' => array_merge($requestBody, ['user' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'user', 'message' => 'This id does not exist.'],
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
        $this->assertCount(count(AgentFixtures::AGENTS), json_decode($response));

        $agent = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Agent::class, AgentFixtures::AGENT_ID_1);

        $this->assertJsonContains([
            'id' => AgentFixtures::AGENT_ID_1,
            'name' => 'Alessandro',
            'image' => $agent->getImage(),
            'shortBio' => 'Desenvolvedor e evangelista de Software',
            'longBio' => 'Fomentador da comunidade de desenvolvimento, um dos fundadores da maior comunidade de PHP do Ceará (PHP com Rapadura)',
            'culture' => false,
            'main' => false,
            'user' => ['id' => UserFixtures::USER_ID_1],
            'organizations' => [
                ['id' => OrganizationFixtures::ORGANIZATION_ID_2],
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => '2024-07-10T11:37:00+00:00',
            'deletedAt' => null,
        ]);
    }

    public function testGetItem(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, AgentFixtures::AGENT_ID_3);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        /* @var Agent $agent */
        $agent = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Agent::class, AgentFixtures::AGENT_ID_3);

        $this->assertResponseBodySame([
            'id' => AgentFixtures::AGENT_ID_3,
            'name' => 'Anna Kelly',
            'image' => $agent->getImage(),
            'shortBio' => 'Desenvolvedora frontend e entusiasta de UX',
            'longBio' => 'Desenvolvedora frontend especializada em criar interfaces intuitivas e acessíveis. Entusiasta de UX e está sempre em busca de melhorias na experiência do usuário.',
            'culture' => false,
            'main' => false,
            'extraFields' => [
                'email' => 'anna@example.com',
                'instagram' => '@anna',
            ],
            'user' => ['id' => UserFixtures::USER_ID_3],
            'organizations' => [],
            'addresses' => [
                [
                    'id' => '425bdb7a-1ea2-41b5-bcb8-3511ef8f750a',
                    'street' => 'Rua das Flores',
                    'number' => '123',
                    'neighborhood' => 'Primavera',
                    'complement' => 'Bloco A',
                    'city' => [
                        'name' => 'Pedra Branca',
                        'state' => [
                            'name' => 'Ceará',
                            'acronym' => 'CE',
                        ],
                    ],
                    'zipcode' => '01002000',
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
                'description' => 'The requested Agent was not found.',
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
                'description' => 'The requested Agent was not found.',
            ],
        ]);
    }

    public function testDeleteAgentWhenIsTheUniqueFromUserShouldBeRetrieveAnError(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, AgentFixtures::AGENT_ID_4);

        $client->request(Request::METHOD_DELETE, $url);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'error_general',
            'error_details' => [
                'description' => 'Cannot remove unique agent from user.',
            ],
        ]);
    }

    public function testDeleteAgentItemWithSuccess(): void
    {
        $client = static::apiClient(user: UserFixtures::USERS[0]['email']);

        $requestBody = AgentTestFixtures::complete();

        $client->request(Request::METHOD_POST, self::BASE_URL, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $url = sprintf('%s/%s', self::BASE_URL, AgentFixtures::AGENT_ID_4);

        $client->request(Request::METHOD_DELETE, $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $client->request(Request::METHOD_GET, $url);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testCanUpdate(): void
    {
        $requestBody = AgentTestFixtures::complete();
        unset($requestBody['id']);
        unset($requestBody['image']);

        $url = sprintf('%s/%s', self::BASE_URL, AgentFixtures::AGENT_ID_5);
        $client = self::apiClient();

        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $agent = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Agent::class, AgentFixtures::AGENT_ID_5);

        $this->assertResponseBodySame([
            'id' => AgentFixtures::AGENT_ID_5,
            'name' => $requestBody['name'],
            'image' => $agent->getImage(),
            'shortBio' => $requestBody['shortBio'],
            'longBio' => $requestBody['longBio'],
            'culture' => $requestBody['culture'],
            'main' => $requestBody['main'],
            'extraFields' => $requestBody['extraFields'],
            'user' => ['id' => UserFixtures::USER_ID_1],
            'organizations' => [
                ['id' => OrganizationFixtures::ORGANIZATION_ID_1],
            ],
            'addresses' => [
                [
                    'id' => AddressFixtures::ADDRESS_ID_5,
                    'street' => 'Travessa do Sol',
                    'number' => '7',
                    'neighborhood' => 'Aurora',
                    'complement' => null,
                    'city' => [
                        'name' => 'Brejo Santo',
                        'state' => [
                            'name' => 'Ceará',
                            'acronym' => 'CE',
                        ],
                    ],
                    'zipcode' => '30330110',
                ],
            ],
            'createdAt' => $agent->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $agent->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);
    }

    public function testCanUpdateImageWithMultipartFormData(): void
    {
        $file = ImageTestFixtures::getImageValid();

        $url = sprintf('%s/%s/images', self::BASE_URL, AgentFixtures::AGENT_ID_3);

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

        /* @var Agent $agent */
        $agent = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Agent::class, AgentFixtures::AGENT_ID_3);

        $this->assertResponseBodySame([
            'id' => AgentFixtures::AGENT_ID_3,
            'name' => 'Anna Kelly',
            'image' => $agent->getImage(),
            'shortBio' => 'Desenvolvedora frontend e entusiasta de UX',
            'longBio' => 'Desenvolvedora frontend especializada em criar interfaces intuitivas e acessíveis. Entusiasta de UX e está sempre em busca de melhorias na experiência do usuário.',
            'culture' => false,
            'main' => false,
            'extraFields' => [
                'email' => 'anna@example.com',
                'instagram' => '@anna',
            ],
            'user' => ['id' => UserFixtures::USER_ID_3],
            'organizations' => [],
            'addresses' => [
                [
                    'id' => AddressFixtures::ADDRESS_ID_3,
                    'street' => 'Rua das Flores',
                    'number' => '123',
                    'neighborhood' => 'Primavera',
                    'complement' => 'Bloco A',
                    'city' => [
                        'name' => 'Pedra Branca',
                        'state' => [
                            'name' => 'Ceará',
                            'acronym' => 'CE',
                        ],
                    ],
                    'zipcode' => '01002000',
                ],
            ],
            'createdAt' => $agent->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => $agent->getUpdatedAt()->format(DateTimeInterface::ATOM),
            'deletedAt' => null,
        ]);
    }

    #[DataProvider('provideValidationUpdateCases')]
    public function testValidationUpdate(array $requestBody, array $expectedErrors): void
    {
        $client = self::apiClient();
        $url = sprintf('%s/%s', self::BASE_URL, AgentFixtures::AGENT_ID_6);
        $client->request(Request::METHOD_PATCH, $url, content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseBodySame([
            'error_message' => 'not_valid',
            'error_details' => $expectedErrors,
        ]);
    }

    public static function provideValidationUpdateCases(): array
    {
        $requestBody = AgentTestFixtures::partial();
        unset($requestBody['id']);

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
            'shortBio should be string' => [
                'requestBody' => array_merge($requestBody, ['shortBio' => 123]),
                'expectedErrors' => [
                    ['field' => 'shortBio', 'message' => 'This value should be of type string.'],
                ],
            ],
            'shortBio too long' => [
                'requestBody' => array_merge($requestBody, ['shortBio' => str_repeat('a', 256)]),
                'expectedErrors' => [
                    ['field' => 'shortBio', 'message' => 'This value is too long. It should have 100 characters or less.'],
                ],
            ],
            'longBio should be string' => [
                'requestBody' => array_merge($requestBody, ['longBio' => 123]),
                'expectedErrors' => [
                    ['field' => 'longBio', 'message' => 'This value should be of type string.'],
                ],
            ],
            'longBio too long' => [
                'requestBody' => array_merge($requestBody, ['longBio' => str_repeat('a', 256)]),
                'expectedErrors' => [
                    ['field' => 'longBio', 'message' => 'This value is too long. It should have 255 characters or less.'],
                ],
            ],
            'culture should be boolean' => [
                'requestBody' => array_merge($requestBody, ['culture' => 'invalid']),
                'expectedErrors' => [
                    ['field' => 'culture', 'message' => 'This value should be of type bool.'],
                ],
            ],
            'organizations should be an array' => [
                'requestBody' => array_merge($requestBody, ['organizations' => 'invalid']),
                'expectedErrors' => [
                    ['field' => 'organizations', 'message' => 'This value should be of type iterable.'],
                ],
            ],
            'organizations is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['organizations' => ['invalid-uuid']]),
                'expectedErrors' => [
                    ['field' => 'organizations[0]', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'organizations should exist' => [
                'requestBody' => array_merge($requestBody, ['organizations' => [Uuid::v4()->toRfc4122()]]),
                'expectedErrors' => [
                    ['field' => 'organizations[0]', 'message' => 'This id does not exist.'],
                ],
            ],
            'extraFields should be a valid JSON' => [
                'requestBody' => array_merge($requestBody, ['extraFields' => 'invalid-json']),
                'expectedErrors' => [
                    ['field' => 'extraFields', 'message' => 'This value should be of type json object.'],
                ],
            ],
            'user is not a valid UUID' => [
                'requestBody' => array_merge($requestBody, ['user' => 'invalid-uuid']),
                'expectedErrors' => [
                    ['field' => 'user', 'message' => 'This value is not a valid UUID.'],
                ],
            ],
            'user should exist' => [
                'requestBody' => array_merge($requestBody, ['user' => Uuid::v4()->toRfc4122()]),
                'expectedErrors' => [
                    ['field' => 'user', 'message' => 'This id does not exist.'],
                ],
            ],
            'user should be not null' => [
                'requestBody' => array_merge($requestBody, ['user' => null]),
                'expectedErrors' => [
                    ['field' => 'user', 'message' => 'This value should not be null.'],
                ],
            ],
        ];
    }

    #[DataProvider('provideValidationUpdateImageCases')]
    public function testValidationUpdateImage(array $requestBody, $file, array $expectedErrors): void
    {
        $url = sprintf('%s/%s/images', self::BASE_URL, AgentFixtures::AGENT_ID_6);

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
        $requestBody = AgentTestFixtures::partial();
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

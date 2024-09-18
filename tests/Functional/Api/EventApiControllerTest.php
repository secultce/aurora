<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\EventFixtures;
use App\DataFixtures\Entity\InitiativeFixtures;
use App\DataFixtures\Entity\SpaceFixtures;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class EventApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URI = '/api/events';

    public function testGet(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, self::BASE_URI);
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
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testGetItem(): void
    {
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URI, EventFixtures::EVENT_ID_6);

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
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_2,
                ],
                'createdAt' => '2024-07-16T17:22:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
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
        $client = static::createClient();

        $client->request(Request::METHOD_GET, sprintf('%s/%s', self::BASE_URI, Uuid::v4()->toRfc4122()));

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
        $client = static::createClient();

        $client->request(Request::METHOD_DELETE, sprintf('%s/%s', self::BASE_URI, Uuid::v4()->toRfc4122()));

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
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URI, EventFixtures::EVENT_ID_4);

        $client->request(Request::METHOD_DELETE, $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $client->request(Request::METHOD_GET, $url);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}

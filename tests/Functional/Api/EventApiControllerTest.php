<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\AgentFixtures;
use App\DataFixtures\EventFixtures;
use App\DataFixtures\InitiativeFixtures;
use App\DataFixtures\SpaceFixtures;
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
        $this->assertResponseBodySame([
            [
                'id' => '8042b9aa-91b9-43f7-8829-101da3086a27',
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
            ],
            [
                'id' => 'f718952a-1bbf-4d7b-85aa-9e6c2d901cb1',
                'name' => 'PHP com Rapadura 10 anos',
                'agentGroup' => null,
                'space' => null,
                'initiative' => null,
                'parent' => null,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_1,
                ],
                'createdAt' => '2024-07-11T10:49:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '4b92555b-9f6b-4163-8977-c38af0df36b0',
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
            [
                'id' => 'f6b6ef5d-2b23-45d2-a7e3-dd5cae67c98a',
                'name' => 'Encontro de Saberes',
                'agentGroup' => null,
                'space' => [
                    'id' => SpaceFixtures::SPACE_ID_4,
                ],
                'initiative' => [
                    'id' => InitiativeFixtures::INITIATIVE_ID_9,
                ],
                'parent' => EventFixtures::EVENT_ID_3,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_2,
                ],
                'createdAt' => '2024-07-17T15:12:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '474a2771-f941-46c6-969e-1e5ceb166444',
                'name' => 'Vozes do Interior',
                'agentGroup' => null,
                'space' => [
                    'id' => SpaceFixtures::SPACE_ID_4,
                ],
                'initiative' => [
                    'id' => InitiativeFixtures::INITIATIVE_ID_5,
                ],
                'parent' => EventFixtures::EVENT_ID_3,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_3,
                ],
                'createdAt' => '2024-07-22T16:20:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '64f6d8a0-6326-4c15-bec1-d4531720f578',
                'name' => 'Cores do Sertão',
                'agentGroup' => null,
                'space' => [
                    'id' => SpaceFixtures::SPACE_ID_3,
                ],
                'initiative' => [
                    'id' => InitiativeFixtures::INITIATIVE_ID_10,
                ],
                'parent' => EventFixtures::EVENT_ID_3,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_3,
                ],
                'createdAt' => '2024-08-10T11:26:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'a963d40a-f6e7-4eab-a9c9-3222dfa443f2',
                'name' => 'Raízes do Sertão',
                'agentGroup' => null,
                'space' => [
                    'id' => SpaceFixtures::SPACE_ID_6,
                ],
                'initiative' => [
                    'id' => InitiativeFixtures::INITIATIVE_ID_1,
                ],
                'parent' => EventFixtures::EVENT_ID_3,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_4,
                ],
                'createdAt' => '2024-08-11T15:54:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '96318947-df03-41c9-be75-095a85c12e96',
                'name' => 'Festival da Rapadura',
                'agentGroup' => null,
                'space' => [
                    'id' => SpaceFixtures::SPACE_ID_6,
                ],
                'initiative' => [
                    'id' => InitiativeFixtures::INITIATIVE_ID_2,
                ],
                'parent' => null,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_4,
                ],
                'createdAt' => '2024-08-12T14:24:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'cb3b5e40-604b-49e5-a21f-442b43a8a3a9',
                'name' => 'Cultura em ação',
                'agentGroup' => null,
                'space' => [
                    'id' => SpaceFixtures::SPACE_ID_10,
                ],
                'initiative' => [
                    'id' => InitiativeFixtures::INITIATIVE_ID_4,
                ],
                'parent' => null,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_5,
                ],
                'createdAt' => '2024-08-13T20:25:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '9f0e3630-f9e1-42ca-8e6b-b1dcaa006797',
                'name' => 'Nordeste Literário',
                'agentGroup' => null,
                'space' => [
                    'id' => SpaceFixtures::SPACE_ID_6,
                ],
                'initiative' => [
                    'id' => InitiativeFixtures::INITIATIVE_ID_1,
                ],
                'parent' => null,
                'createdBy' => [
                    'id' => AgentFixtures::AGENT_ID_5,
                ],
                'createdAt' => '2024-08-14T10:00:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
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

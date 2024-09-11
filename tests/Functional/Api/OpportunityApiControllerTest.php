<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\AgentFixtures;
use App\DataFixtures\EventFixtures;
use App\DataFixtures\InitiativeFixtures;
use App\DataFixtures\OpportunityFixtures;
use App\DataFixtures\SpaceFixtures;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class OpportunityApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/opportunities';

    public function testGet(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, self::BASE_URL);
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(count(OpportunityFixtures::OPPORTUNITIES), json_decode($response));

        $this->assertJsonContains([
            'id' => OpportunityFixtures::OPPORTUNITY_ID_1,
            'name' => 'Inscrição para o Concurso de Cordelistas - Festival de Literatura Nordestina',
            'parent' => null,
            'space' => [
                'id' => SpaceFixtures::SPACE_ID_1,
            ],
            'initiative' => [
                'id' => InitiativeFixtures::INITIATIVE_ID_1,
            ],
            'event' => [
                'id' => EventFixtures::EVENT_ID_1,
            ],
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'createdAt' => '2024-09-06T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testGetAnOpportunityItemWithSuccess(): void
    {
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URL, OpportunityFixtures::OPPORTUNITY_ID_3);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseBodySame([
            'id' => OpportunityFixtures::OPPORTUNITY_ID_3,
            'name' => 'Credenciamento de Quadrilhas Juninas - São João do Nordeste',
            'parent' => null,
            'space' => [
                'id' => SpaceFixtures::SPACE_ID_3,
            ],
            'initiative' => [
                'id' => InitiativeFixtures::INITIATIVE_ID_3,
            ],
            'event' => [
                'id' => EventFixtures::EVENT_ID_3,
            ],
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_3,
            ],
            'createdAt' => '2024-09-08T12:00:00+00:00',
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
                'description' => 'The requested Opportunity was not found.',
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
                'description' => 'The requested Opportunity was not found.',
            ],
        ]);
    }

    public function testDeleteAResourceWithSuccess(): void
    {
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URL, OpportunityFixtures::OPPORTUNITY_ID_3);

        $client->request(Request::METHOD_DELETE, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}

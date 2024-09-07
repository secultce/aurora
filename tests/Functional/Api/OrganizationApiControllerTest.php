<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\AgentFixtures;
use App\DataFixtures\OrganizationFixtures;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class OrganizationApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/organizations';

    public function testGet(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, self::BASE_URL);
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(count(OrganizationFixtures::ITEMS), json_decode($response));

        $this->assertJsonContains([
            'id' => OrganizationFixtures::ORGANIZATION_ID_1,
            'name' => 'PHP com Rapadura',
            'description' => 'Comunidade de devs PHP do Estado do Ceará',
            'agents' => [],
            'owner' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_1,
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testGetAnOrganizationItemWithSuccess(): void
    {
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URL, OrganizationFixtures::ORGANIZATION_ID_3);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseBodySame([
            'id' => OrganizationFixtures::ORGANIZATION_ID_3,
            'name' => 'Devs do Sertão',
            'description' => 'Grupo de devs que se reúnem velas veredas do sertão',
            'agents' => [],
            'owner' => [
                'id' => AgentFixtures::AGENT_ID_3,
            ],
            'createdBy' => [
                'id' => AgentFixtures::AGENT_ID_3,
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
                'description' => 'The requested Organization was not found.',
            ],
        ]);
    }
}

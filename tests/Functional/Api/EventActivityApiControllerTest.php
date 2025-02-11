<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\EventActivityFixtures;
use App\DataFixtures\Entity\EventFixtures;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class EventActivityApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/events/{event}/activities';

    public function testGetACollectionActivitiesOfEvents(): void
    {
        $url = str_replace('{event}', EventFixtures::EVENT_ID_3, self::BASE_URL);

        $client = static::apiClient();
        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertJsonContains([
            'id' => EventActivityFixtures::EVENT_ACTIVITY_ID_3,
            'event' => [
                'id' => EventFixtures::EVENT_ID_3,
            ],
            'title' => 'Abertura do músical',
            'description' => 'Abertura do músical',
            'startDate' => '2024-07-16T17:22:00+00:00',
            'endDate' => '2024-07-17T17:22:00+00:00',
        ]);
    }

    public function testGetAnEventItem(): void
    {
        $client = static::apiClient();

        $url = str_replace('{event}', EventFixtures::EVENT_ID_3, self::BASE_URL);
        $url = sprintf('%s/%s', $url, EventActivityFixtures::EVENT_ACTIVITY_ID_3);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertResponseBodySame([
            'id' => EventActivityFixtures::EVENT_ACTIVITY_ID_3,
            'event' => [
                'id' => EventFixtures::EVENT_ID_3,
            ],
            'title' => 'Abertura do músical',
            'description' => 'Abertura do músical',
            'startDate' => '2024-07-16T17:22:00+00:00',
            'endDate' => '2024-07-17T17:22:00+00:00',
        ]);
    }

    public function testGetAResourceWhenNotFound(): void
    {
        $client = static::apiClient();

        $url = str_replace('{event}', EventFixtures::EVENT_ID_4, self::BASE_URL);

        $client->request(Request::METHOD_GET, sprintf('%s/%s', $url, Uuid::v4()->toRfc4122()));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertResponseBodySame([
            'error_message' => 'not_found',
            'error_details' => [
                'description' => 'The requested EventActivity was not found.',
            ],
        ]);
    }

    public function testDeleteAResourceWhenNotFound(): void
    {
        $client = static::apiClient();

        $url = str_replace('{event}', EventFixtures::EVENT_ID_4, self::BASE_URL);

        $client->request(Request::METHOD_DELETE, sprintf('%s/%s', $url, Uuid::v4()->toRfc4122()));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertResponseBodySame([
            'error_message' => 'not_found',
            'error_details' => [
                'description' => 'The requested EventActivity was not found.',
            ],
        ]);
    }

    public function testDeleteAnEventItemWithSuccess(): void
    {
        $client = static::apiClient();

        $url = str_replace('{event}', EventFixtures::EVENT_ID_4, self::BASE_URL);
        $url = sprintf('%s/%s', $url, EventActivityFixtures::EVENT_ACTIVITY_ID_4);

        $client->request(Request::METHOD_DELETE, $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $client->request(Request::METHOD_GET, $url);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}

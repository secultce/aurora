<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\SpaceFixtures;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class SpaceApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/spaces';

    public function testGet(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, self::BASE_URL);
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(count(SpaceFixtures::SPACES), json_decode($response));
        $this->assertResponseBodySame([
            [
                'id' => '69461af3-52f2-4c6b-ad30-ce92e478e9bd',
                'name' => 'SECULT',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => null,
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
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
            [
                'id' => '608756eb-4830-49f2-ae14-1160ca5252f4',
                'name' => 'Galeria Caatinga',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => 'ae32b8a5-25a8-4b80-b415-4237a8484186',
                'createdAt' => '2024-07-16T17:22:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '25dc221a-f4a6-4e40-94c3-73b1d553f2c1',
                'name' => 'Recanto do Cordel',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => '608756eb-4830-49f2-ae14-1160ca5252f4',
                'createdAt' => '2024-07-17T15:12:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '46137ea7-6ca9-4782-b940-b45c74716a4f',
                'name' => 'Ritmos do Mundo',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => '608756eb-4830-49f2-ae14-1160ca5252f4',
                'createdAt' => '2024-07-22T16:20:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'a54d5bc6-0748-4554-aaf9-80cad467f991',
                'name' => 'Casa do Sertão',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => '608756eb-4830-49f2-ae14-1160ca5252f4',
                'createdAt' => '2024-08-10T11:26:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'd53c4e9b-b72c-4b22-b18d-be8f404cd242',
                'name' => 'Vila do Baião',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => 'a54d5bc6-0748-4554-aaf9-80cad467f991',
                'createdAt' => '2024-08-11T15:54:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '86071ac5-021c-4e44-a200-7159fe57a810',
                'name' => 'Centro Cultural Asa Branca',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => null,
                'createdAt' => '2024-08-12T14:24:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'eaf6a58d-ff9b-4446-8e1a-9bb9164adc74',
                'name' => 'Casa da Capoeira',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => null,
                'createdAt' => '2024-08-13T20:25:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'b4a49f4d-25ca-40f9-bac2-e72383b689ed',
                'name' => 'Dragão do Mar',
                'createdBy' => [
                    'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                ],
                'parent' => null,
                'createdAt' => '2024-08-14T10:00:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
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

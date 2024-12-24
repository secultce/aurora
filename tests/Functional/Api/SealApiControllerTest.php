<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\Entity\SealFixtures;
use App\Entity\Seal;
use App\Tests\AbstractWebTestCase;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class SealApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/seals';

    public function testGet(): void
    {
        $client = static::apiClient();

        $client->request(Request::METHOD_GET, self::BASE_URL);
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(2, json_decode($response));

        /* @var Seal $seal */
        $seal = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Seal::class, SealFixtures::SEAL_ID_9);

        $this->assertJsonContains([
            'id' => SealFixtures::SEAL_ID_9,
            'name' => 'Artes e Ofícios',
            'description' => 'Selo que valoriza projetos relacionados a artesanato e cultura manual.',
            'active' => false,
            'createdBy' => [],
            'expirationDate' => $seal->getExpirationDate()->format(DateTimeInterface::ATOM),
            'createdAt' => $seal->getCreatedAt()->format(DateTimeInterface::ATOM),
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testGetASealItemWithSuccess(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, SealFixtures::SEAL_ID_3);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $seal = $client->getContainer()->get(EntityManagerInterface::class)
            ->find(Seal::class, SealFixtures::SEAL_ID_3);

        $this->assertResponseBodySame([
            'id' => SealFixtures::SEAL_ID_3,
            'name' => 'Sustentabilidade',
            'description' => 'Selo para iniciativas comprometidas com práticas sustentáveis.',
            'active' => false,
            'createdBy' => [],
            'expirationDate' => $seal->getExpirationDate()->format(DateTimeInterface::ATOM),
            'createdAt' => $seal->getCreatedAt()->format(DateTimeInterface::ATOM),
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
                'description' => 'The requested Seal was not found.',
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
                'description' => 'The requested Seal was not found.',
            ],
        ]);
    }

    public function testDeleteASealItemWithSuccess(): void
    {
        $client = static::apiClient();

        $url = sprintf('%s/%s', self::BASE_URL, SealFixtures::SEAL_ID_2);

        $client->request(Request::METHOD_DELETE, $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $client->request(Request::METHOD_GET, $url);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExampleApiTest extends AbstractWebTestCase
{
    public function testRouteNotExists(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $client = static::createClient();
        $client->catchExceptions(false);

        $client->request(Request::METHOD_GET, '/api/not-existent');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testRouteExistWithResponseIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/api/example');
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertEquals(json_encode([
            'message' => 'Hello world',
        ]), $response);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/login';

    public function testCanLogin(): void
    {
        $requestBody = [
            'username' => 'henriquelopeslima@example.com',
            'password' => '123456',
        ];

        $client = self::createClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, server: [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ], content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $responseArray = self::getCurrentResponseArray();

        self::assertArrayHasKey('token', $responseArray);
        self::assertSame($requestBody['username'], $responseArray['user']);
    }

    public function testCannotLogin(): void
    {
        $requestBody = [
            'username' => 'henriquelopeslima@example.com',
            'password' => 'invalid',
        ];

        $client = self::createClient();

        $client->request(Request::METHOD_POST, self::BASE_URL, server: [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ], content: json_encode($requestBody));

        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        self::assertResponseBodySame([
            'message' => 'unauthorized',
            'details' => [
                'The credentials you provided are invalid. Please try again.',
            ],
        ]);
    }
}

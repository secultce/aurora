<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Exception\BadMethodCallException;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected function assertResponseBodySame(array $expectedContent): void
    {
        $response = $this->getCurrentResponse();

        $content = json_decode($response->getContent(), true);

        self::assertSame($expectedContent, $content);
    }

    protected function assertJsonContains(array $expectedContent): void
    {
        $response = $this->getCurrentResponse();

        $content = json_decode($response->getContent(), true);

        $this->assertContains($expectedContent, $content);
    }

    protected function getCurrentResponse(): Response
    {
        $response = self::getClient()->getResponse();

        if (false === $response instanceof Response) {
            throw new BadMethodCallException('You need to make a request before trying to get the response.');
        }

        return $response;
    }

    protected function getCurrentResponseArray(): array
    {
        return json_decode($this->getCurrentResponse()->getContent(), true);
    }

    protected static function getToken(string $username = 'henriquelopeslima@example.com'): string
    {
        $container = self::getContainer();

        $entityManager = $container->get('doctrine.orm.default_entity_manager');
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $username]);

        return 'Bearer '.$container->get('lexik_jwt_authentication.jwt_manager')->create($user);
    }

    protected static function apiClient(array $options = [], array $server = []): KernelBrowser
    {
        $token = self::getToken();

        if (null !== static::$kernel) {
            static::ensureKernelShutdown();
        }

        if ([] === $server) {
            $server = [
                'HTTP_ACCEPT' => 'application/json',
                'HTTP_CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => $token,
            ];
        }

        return self::createClient($options, $server);
    }
}

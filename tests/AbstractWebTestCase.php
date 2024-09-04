<?php

declare(strict_types=1);

namespace App\Tests;

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
}

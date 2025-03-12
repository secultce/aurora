<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Utils\WebLoginHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = self::createClient();

        if (self::getContainer()->has('session.factory')) {
            $session = self::getContainer()->get('session.factory')->createSession();
            $session->start();
            $this->client->getContainer()->set(SessionInterface::class, $session);

            WebLoginHelper::login($this->client, 'henriquelopeslima@example.com', 'Aurora@2024');
        }
    }
}

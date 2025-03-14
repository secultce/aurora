<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Utils\WebLoginHelper;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class AbstractAdminWebTestCase extends AbstractWebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $session = self::getContainer()->get('session.factory')->createSession();

        $session->start();
        $this->client->getContainer()->set(SessionInterface::class, $session);

        WebLoginHelper::login($this->client, 'henriquelopeslima@example.com', 'Aurora@2024');
    }
}

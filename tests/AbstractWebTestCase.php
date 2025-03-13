<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected KernelBrowser $client;
    protected TranslatorInterface $translator;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->translator = static::getContainer()->get(TranslatorInterface::class);
    }
}

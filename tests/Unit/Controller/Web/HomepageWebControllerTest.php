<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Web;

use App\Controller\Web\HomepageWebController;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomepageWebControllerTest extends AbstractWebTestCase
{
    private HomepageWebController $controller;
    private TranslatorInterface $translator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = static::getContainer()->get(HomepageWebController::class);
        $this->translator = static::getContainer()->get(TranslatorInterface::class);
    }

    public function testHomePageExists(): void
    {
        $this->assertInstanceOf(Response::class, $this->controller->homepage());
    }

    public function testHomePageRenderHTMLWithSuccess(): void
    {
        $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', $this->translator->trans('view.homepage.title'));
    }
}

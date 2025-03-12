<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Web;

use App\Controller\Web\FaqWebController;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class FaqWebControllerTest extends AbstractWebTestCase
{
    private FaqWebController $controller;
    private TranslatorInterface $translator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = static::getContainer()->get(FaqWebController::class);
        $this->translator = static::getContainer()->get(TranslatorInterface::class);
    }

    public function testFaqPageExists(): void
    {
        $this->assertInstanceOf(Response::class, $this->controller->faq());
    }

    public function testFaqPageRenderHTMLWithSuccess(): void
    {
        $this->client->request('GET', '/faq');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', $this->translator->trans('view.faq.title'));
    }
}

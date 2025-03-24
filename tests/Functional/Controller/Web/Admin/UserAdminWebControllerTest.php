<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Web\Admin;

use App\Controller\Web\Admin\UserAdminController;
use App\DataFixtures\Entity\UserFixtures;
use App\Tests\AbstractAdminWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class UserAdminWebControllerTest extends AbstractAdminWebTestCase
{
    private UserAdminController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = static::getContainer()->get(UserAdminController::class);
    }

    public function testListPageRenderHTMLWithSuccess(): void
    {
        $listUrl = $this->router->generate('admin_user_list');

        $this->client->request(Request::METHOD_GET, $listUrl);

        $response = $this->client->getResponse();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', $this->translator->trans('Usuários'));
        $this->assertSelectorTextContains('tr  th:nth-of-type(1)', $this->translator->trans('name'));
        $this->assertSelectorTextContains('tr  th:nth-of-type(2)', $this->translator->trans('email'));
        $this->assertSelectorTextContains('tr  th:nth-of-type(3)', $this->translator->trans('image'));
        $this->assertSelectorTextContains('tr  th:nth-of-type(4)', $this->translator->trans('created_at'));
        $this->assertSelectorTextContains('tr  th:nth-of-type(5)', $this->translator->trans('actions'));
    }

    public function testControllerListMethodDirectly(): void
    {
        $this->assertInstanceOf(Response::class, $this->controller->list());
    }

    public function testTimelinePageRenderHTMLWithSuccess(): void
    {
        $timelineUrl = $this->router->generate('admin_user_timeline', [
            'id' => Uuid::fromString(UserFixtures::USER_ID_3),
        ]);

        $this->client->request(Request::METHOD_GET, $timelineUrl);

        $this->assertResponseIsSuccessful();
    }

    public function testTimelineNotFound(): void
    {
        $timelineUrl = $this->router->generate('admin_user_timeline', [
            'id' => Uuid::v4()->toRfc4122(),
        ]);

        $this->client->request(Request::METHOD_GET, $timelineUrl);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testAccountPrivacyPageRenderHTMLWithSuccess(): void
    {
        $accountPrivacyUrl = $this->router->generate('admin_user_account_privacy', [
            'id' => Uuid::fromString(UserFixtures::USER_ID_3),
        ]);

        $this->client->request(Request::METHOD_GET, $accountPrivacyUrl);

        $this->assertResponseIsSuccessful();
    }

    public function testAccountPrivacyRedirectsToLoginWhenUserNotFound(): void
    {
        $this->client->request(Request::METHOD_GET, '/logout');

        $accountPrivacyUrl = $this->router->generate('admin_user_account_privacy', [
            'id' => Uuid::v4()->toRfc4122(),
        ]);

        $this->client->request(Request::METHOD_GET, $accountPrivacyUrl);

        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }
}

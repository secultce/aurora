<?php

declare(strict_types=1);

namespace Functional\DocumentServices;

use App\DocumentService\Interface\AuthTimelineDocumentServiceInterface;
use App\Repository\UserRepository;
use App\Tests\AbstractWebTestCase;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthTimelineDocumentServiceTest extends AbstractWebTestCase
{
    private AuthTimelineDocumentServiceInterface $authTimelineDocumentService;

    private UserInterface $user;

    protected function setUp(): void
    {
        $client = static::createClient();
        $this->authTimelineDocumentService = $client->getContainer()->get(AuthTimelineDocumentServiceInterface::class);
        $this->user = $client->getContainer()->get(UserRepository::class)->findOneByEmail('talysonsoares@example.com');

        $client->loginUser($this->user);
    }

    public function testGetTimelineLoginByUser(): void
    {
        $timeline = $this->authTimelineDocumentService->getTimelineLoginByUserId($this->user->getId());

        $this->assertIsArray($timeline);
        $this->assertGreaterThan(1, count($timeline));

        foreach ($timeline as $entry) {
            $this->assertObjectHasProperty('userId', $entry);
            $this->assertObjectHasProperty('action', $entry);
            $this->assertObjectHasProperty('datetime', $entry);
            $this->assertEquals($this->user->getId(), $entry->getUserId());
            $this->assertEquals('login success', $entry->getAction());
            $this->assertInstanceOf(DateTime::class, $entry->getDatetime());
        }
    }
}

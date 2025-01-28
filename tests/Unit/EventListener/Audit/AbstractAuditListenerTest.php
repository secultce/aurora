<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener\Audit;

use App\EventListener\Audit\AbstractAuditListener;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class AbstractAuditListenerTest extends KernelTestCase
{
    public const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36';

    private AbstractAuditListener $auditListener;

    protected function setUp(): void
    {
        parent::setUp();

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn(
                new Request(server: [
                    'HTTP_USER_AGENT' => self::USER_AGENT,
                ])
            );

        $documentManager = $this->createMock(DocumentManager::class);
        $security = $this->createMock(Security::class);

        $auditListenerConcrete = new class ($documentManager, $requestStack, $security) extends AbstractAuditListener {
            public function getDevice(): string
            {
                return parent::getDevice();
            }

            public function getPlatform(): string
            {
                return parent::getPlatform();
            }
        };

        $this->auditListener = new $auditListenerConcrete($documentManager, $requestStack, $security);
    }

    public function testGetDevice(): void
    {
        $this->assertSame('Chrome', $this->auditListener->getDevice());
    }

    public function testGetPlatform(): void
    {
        $this->assertSame('Windows', $this->auditListener->getPlatform());
    }
}

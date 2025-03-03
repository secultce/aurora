<?php

declare(strict_types=1);

namespace App\Tests\Functional\DocumentService;

use App\DataFixtures\Entity\OrganizationFixtures;
use App\Document\AbstractDocument;
use App\Document\OrganizationTimeline;
use App\DocumentService\AbstractTimelineDocumentService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

final class AbstractTimelineDocumentServiceTest extends KernelTestCase
{
    private DocumentManager $documentManager;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();
        $this->documentManager = $kernel->getContainer()->get('doctrine_mongodb')->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->documentManager->close();
        unset($this->documentManager);
    }

    public function testGetEventsByEntityId(): void
    {
        $organizationId = Uuid::fromRfc4122(OrganizationFixtures::ORGANIZATION_ID_1);

        $timelineDocumentService = $this->createAbstractClass(OrganizationTimeline::class);

        $events = $timelineDocumentService->getEventsByEntityId($organizationId);

        $this->assertIsArray($events);
        $this->assertInstanceOf(AbstractDocument::class, $events[0]);
        $this->assertInstanceOf(AbstractDocument::class, $events[1]);

        $this->assertEquals($events[0]->getResourceId(), OrganizationFixtures::ORGANIZATION_ID_1);
        $this->assertEquals($events[0]->getTitle(), 'The resource was created');
        $this->assertEquals($events[0]->getPriority(), 0);
        $this->assertEquals($events[0]->getDevice(), 'unknown');
        $this->assertEquals($events[0]->getPlatform(), 'unknown');
        $this->assertEmpty($events[0]->getFrom());
        $this->assertEquals($events[0]->getTo()['name'], 'PHP sem Rapadura');

        $this->assertEquals($events[1]->getResourceId(), OrganizationFixtures::ORGANIZATION_ID_1);
        $this->assertEquals($events[1]->getTitle(), 'The resource was updated');
        $this->assertEquals($events[1]->getPriority(), 0);
        $this->assertEquals($events[1]->getDevice(), 'unknown');
        $this->assertEquals($events[1]->getPlatform(), 'unknown');
        $this->assertEquals($events[1]->getFrom()['name'], 'PHP sem Rapadura');
        $this->assertEquals($events[1]->getTo()['name'], 'PHP com Rapadura');
    }

    public function testGetEventsByEntityIdWhenDoesNotExistEvents(): void
    {
        $organizationId = Uuid::v4();

        $timelineDocumentService = $this->createAbstractClass(OrganizationTimeline::class);

        $events = $timelineDocumentService->getEventsByEntityId($organizationId);

        $this->assertIsArray($events);
        $this->assertEmpty($events);
    }

    private function createAbstractClass(string $documentClass): AbstractTimelineDocumentService
    {
        return new class ($this->documentManager, $documentClass) extends AbstractTimelineDocumentService {
        };
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\DataFixtures\Entity\AgentFixtures;
use App\DataFixtures\Entity\EventFixtures;
use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class EventServiceTest extends KernelTestCase
{
    private EventService $service;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->service = self::getContainer()->get(EventService::class);
    }

    public function testFindByAgent(): void
    {
        $events = $this->service->findByAgent(AgentFixtures::AGENT_ID_2);

        self::assertIsArray($events);
        self::assertCount(3, $events);
        self::assertEquals(EventFixtures::EVENT_ID_9, $events[0]->getId()->toRfc4122());
        self::assertEquals(EventFixtures::EVENT_ID_8, $events[1]->getId()->toRfc4122());
        self::assertEquals(EventFixtures::EVENT_ID_7, $events[2]->getId()->toRfc4122());
    }
}

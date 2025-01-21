<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document;

use App\Document\AgentTimeline;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\Uid\Uuid;

class AgentDocumentTest extends AbstractWebTestCase
{
    public function testGettersAndSettersFromAgentDocumentShouldBeSuccessful(): void
    {
        $agent = new AgentTimeline();

        $this->assertNull($agent->getId());

        $id = Uuid::v4()->toString();
        $agent->setId($id);

        $this->assertEquals($id, $agent->getId());
        $this->assertIsString($agent->getId());
    }
}

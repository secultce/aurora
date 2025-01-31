<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Agent;
use App\Entity\AgentAddress;
use App\Entity\City;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class AgentAddressTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $agentAddress = new AgentAddress();
        $uuid = Uuid::v4();
        $city = $this->createMock(City::class);
        $agent = $this->createMock(Agent::class);
        $createdAt = new DateTimeImmutable('2025-01-01 00:00:00');
        $updatedAt = new DateTimeImmutable('2025-01-02 00:00:00');
        $deletedAt = new DateTimeImmutable('2025-01-03 00:00:00');

        $agentAddress->setId($uuid);
        $this->assertSame($uuid, $agentAddress->getId());

        $agentAddress->setStreet('Main Street');
        $this->assertSame('Main Street', $agentAddress->getStreet());

        $agentAddress->setNumber('123');
        $this->assertSame('123', $agentAddress->getNumber());

        $agentAddress->setNeighborhood('Downtown');
        $this->assertSame('Downtown', $agentAddress->getNeighborhood());

        $agentAddress->setComplement('Apt. 1');
        $this->assertSame('Apt. 1', $agentAddress->getComplement());

        $agentAddress->setCity($city);
        $this->assertSame($city, $agentAddress->getCity());

        $agentAddress->setZipcode('12345678');
        $this->assertSame('12345678', $agentAddress->getZipcode());

        $agentAddress->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $agentAddress->getCreatedAt());

        $agentAddress->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $agentAddress->getUpdatedAt());

        $agentAddress->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $agentAddress->getDeletedAt());

        $agentAddress->setOwner($agent);
        $this->assertSame($agent, $agentAddress->getOwner());
    }

    public function testToArray(): void
    {
        $uuid = Uuid::v4();
        $city = $this->createMock(City::class);
        $city->method('toArray')->willReturn([
            'id' => 'city-id',
            'name' => 'City Name',
        ]);
        $agent = $this->createMock(Agent::class);
        $agentUuid = Uuid::v4();
        $agent->method('getId')->willReturn($agentUuid);
        $parentData = [
            'id' => $uuid->toRfc4122(),
            'street' => 'Main Street',
            'number' => '123',
            'neighborhood' => 'Downtown',
            'complement' => 'Apt. 1',
            'zipcode' => '12345678',
            'city' => [
                'id' => 'city-id',
                'name' => 'City Name',
            ],
            'createdAt' => '2025-01-01 00:00:00',
            'updatedAt' => '2025-01-02 00:00:00',
            'deletedAt' => '2025-01-03 00:00:00',
        ];

        $agentAddress = $this->getMockBuilder(AgentAddress::class)
            ->onlyMethods(['toArray'])
            ->getMock();

        $agentAddress->method('toArray')->willReturn(array_merge($parentData, [
            'owner' => $agentUuid->toRfc4122(),
        ]));

        $result = $agentAddress->toArray();
        $expectedArray = array_merge($parentData, [
            'owner' => $agentUuid->toRfc4122(),
        ]);

        $this->assertSame($expectedArray, $result);
    }
}

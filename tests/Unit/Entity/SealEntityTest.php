<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Agent;
use App\Entity\SealEntity;
use App\Helper\DateFormatHelper;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class SealEntityTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $seal = new SealEntity();

        $id = Uuid::v4();
        $entityId = Uuid::v4();
        $entityType = 1;
        $authorizedBy = 1;
        $createdBy = $this->createMock(Agent::class);
        $createdAt = new DateTimeImmutable();

        $createdBy->method('getId')->willReturn(Uuid::v4());

        $seal->setId($id);
        $seal->setEntityId($entityId);
        $seal->setEntity($entityType);
        $seal->setAuthorizedBy($authorizedBy);
        $seal->setCreatedBy($createdBy);
        $seal->setCreatedAt($createdAt);

        $this->assertSame($id, $seal->getId());
        $this->assertSame($entityId, $seal->getEntityId());
        $this->assertSame($entityType, $seal->getEntity());
        $this->assertSame($authorizedBy, $seal->getAuthorizedBy());
        $this->assertSame($createdBy, $seal->getCreatedBy());
        $this->assertSame($createdAt, $seal->getCreatedAt());
    }

    public function testToArray(): void
    {
        $seal = new SealEntity();

        $id = Uuid::v4();
        $entityId = Uuid::v4();
        $authorizedBy = 1;
        $createdBy = $this->createMock(Agent::class);
        $createdAt = new DateTimeImmutable();

        $createdByUuid = Uuid::v4();
        $createdBy->method('getId')->willReturn($createdByUuid);

        $seal->setId($id);
        $seal->setEntityId($entityId);
        $seal->setAuthorizedBy($authorizedBy);
        $seal->setCreatedBy($createdBy);
        $seal->setCreatedAt($createdAt);

        $expectedArray = [
            'id' => $id->toRfc4122(),
            'entityId' => $entityId->toRfc4122(),
            'authorizedBy' => $authorizedBy,
            'createdBy' => $createdByUuid->toRfc4122(),
            'createdAt' => $createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
        ];

        $this->assertSame($expectedArray, $seal->toArray());
    }
}

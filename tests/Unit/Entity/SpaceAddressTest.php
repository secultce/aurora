<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Address;
use App\Entity\City;
use App\Entity\Space;
use App\Entity\SpaceAddress;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Uid\Uuid;

class SpaceAddressTest extends TestCase
{
    private function setParentOwner(SpaceAddress $address, Space $owner): void
    {
        $reflection = new ReflectionClass(Address::class);
        $property = $reflection->getProperty('owner');
        $property->setAccessible(true);
        $property->setValue($address, $owner);
    }

    public function testToArray(): void
    {
        $spaceAddress = new SpaceAddress();

        $id = Uuid::v4();
        $street = 'Rua ABC';
        $number = '123';
        $neighborhood = 'Centro';
        $complement = 'Apto 301';
        $zipcode = '99999999';

        $spaceAddress->setId($id);
        $spaceAddress->setStreet($street);
        $spaceAddress->setNumber($number);
        $spaceAddress->setNeighborhood($neighborhood);
        $spaceAddress->setComplement($complement);
        $spaceAddress->setZipcode($zipcode);
        $cityMock = $this->createMock(City::class);
        $cityMock->method('toArray')->willReturn([
            'id' => Uuid::v4()->toRfc4122(),
            'name' => 'Cidade Mockada',
        ]);
        $spaceAddress->setCity($cityMock);
        $ownerId = Uuid::v4();
        $spaceMock = $this->createMock(Space::class);
        $spaceMock->method('getId')->willReturn($ownerId);
        $spaceAddress->setOwner($spaceMock);
        $this->setParentOwner($spaceAddress, $spaceMock);
        $now = new DateTimeImmutable('2025-01-02 10:00:00');
        $spaceAddress->setCreatedAt($now);
        $spaceAddress->setUpdatedAt(null);
        $spaceAddress->setDeletedAt(null);
        $array = $spaceAddress->toArray();

        $this->assertIsArray($array);
        $this->assertSame($id->toRfc4122(), $array['id']);
        $this->assertSame($street, $array['street']);
        $this->assertSame($number, $array['number']);
        $this->assertSame($neighborhood, $array['neighborhood']);
        $this->assertSame($complement, $array['complement']);
        $this->assertSame($zipcode, $array['zipcode']);

        $this->assertArrayHasKey('city', $array);
        $this->assertIsArray($array['city']);
        $this->assertSame($ownerId->toRfc4122(), $array['owner']);
        $this->assertSame('2025-01-02 10:00:00', $array['createdAt']);
        $this->assertNull($array['updatedAt']);
        $this->assertNull($array['deletedAt']);
    }
}

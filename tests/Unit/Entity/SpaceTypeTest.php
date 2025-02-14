<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\SpaceType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class SpaceTypeTest extends TestCase
{
    public function testGettersAndSettersFromSpaceTypeEntityShouldBeSuccessful(): void
    {
        $spaceType = new SpaceType();

        $id = Uuid::v4();
        $name = 'Laboratório';

        $spaceType->setId($id);
        $spaceType->setName($name);

        $this->assertSame($id, $spaceType->getId());
        $this->assertSame($name, $spaceType->getName());

        $this->assertEquals([
            'id' => $id->toRfc4122(),
            'name' => $name,
        ], $spaceType->toArray());
    }
}

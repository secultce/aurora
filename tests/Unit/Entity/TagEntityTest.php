<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Tag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class TagEntityTest extends TestCase
{
    public function testGettersAndSettersFromTagEntityShouldBeSuccessful(): void
    {
        $tag = new Tag();

        $id = Uuid::v4();
        $name = 'tag test';

        $tag->setId($id);
        $tag->setName($name);

        $this->assertSame($id, $tag->getId());
        $this->assertSame($name, $tag->getName());

        $this->assertEquals([
            'id' => $id->toRfc4122(),
            'name' => $name,
        ], $tag->toArray());
    }
}

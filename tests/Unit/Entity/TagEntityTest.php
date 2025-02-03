<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Tag;
use App\Helper\DateFormatHelper;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class TagEntityTest extends TestCase
{
    public function testGettersAndSettersFromTagEntityShouldBeSuccessful(): void
    {
        $tag = new Tag();

        $id = Uuid::v4();
        $name = 'tag test';
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $deletedAt = new DateTime();

        $this->assertNotNull($tag->getCreatedAt());

        $tag->setId($id);
        $tag->setName($name);
        $tag->setCreatedAt($createdAt);
        $tag->setUpdatedAt($updatedAt);
        $tag->setDeletedAt($deletedAt);

        $this->assertSame($id, $tag->getId());
        $this->assertSame($name, $tag->getName());
        $this->assertSame($createdAt, $tag->getCreatedAt());
        $this->assertSame($updatedAt, $tag->getUpdatedAt());
        $this->assertSame($deletedAt, $tag->getDeletedAt());

        $this->assertEquals([
            'id' => $id->toRfc4122(),
            'name' => $name,
            'createdAt' => $createdAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'updatedAt' => $updatedAt->format(DateFormatHelper::DEFAULT_FORMAT),
            'deletedAt' => $deletedAt->format(DateFormatHelper::DEFAULT_FORMAT),
        ], $tag->toArray());
    }
}

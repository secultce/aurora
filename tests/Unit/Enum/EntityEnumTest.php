<?php

declare(strict_types=1);

namespace App\Tests\Unit\Enum;

use App\Enum\EntityEnum;
use App\Enum\Trait\EnumTrait;
use PHPUnit\Framework\TestCase;

class EntityEnumTest extends TestCase
{
    public function testEnumCasesHaveCorrectValues(): void
    {
        $this->assertSame(1, EntityEnum::AGENT->value);
        $this->assertSame(2, EntityEnum::EVENT->value);
        $this->assertSame(3, EntityEnum::INITIATIVE->value);
        $this->assertSame(4, EntityEnum::SPACE->value);
        $this->assertSame(5, EntityEnum::OPPORTUNITY->value);
        $this->assertSame(6, EntityEnum::ORGANIZATION->value);
    }

    public function testEnumTraitMethods(): void
    {
        $keys = EntityEnum::getNames();

        $this->assertIsArray($keys);
        $this->assertContains('agent', $keys);
        $this->assertContains('event', $keys);
        $this->assertContains('initiative', $keys);
        $this->assertContains('space', $keys);
        $this->assertContains('opportunity', $keys);
        $this->assertContains('organization', $keys);
        $this->assertCount(6, $keys);

        $values = EntityEnum::getValues();

        $this->assertIsArray($values);
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);
        $this->assertContains(3, $values);
        $this->assertContains(4, $values);
        $this->assertContains(5, $values);
        $this->assertContains(6, $values);
        $this->assertCount(6, $values);
    }

    public function testEnumUsesEnumTrait(): void
    {
        $usedTraits = class_uses(EntityEnum::class);

        $this->assertIsArray($usedTraits);
        $this->assertArrayHasKey(EnumTrait::class, $usedTraits);
    }
}

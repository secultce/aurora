<?php

declare(strict_types=1);

namespace App\Tests\Unit\Enum;

use App\Enum\AuthorizedByEnum;
use App\Enum\Trait\EnumTrait;
use PHPUnit\Framework\TestCase;

class AuthorizedByEnumTest extends TestCase
{
    public function testEnumCasesHaveCorrectValues(): void
    {
        $this->assertSame(1, AuthorizedByEnum::AGENT->value);
        $this->assertSame(2, AuthorizedByEnum::ORGANIZATION->value);
    }

    public function testEnumTraitMethods(): void
    {
        $keys = AuthorizedByEnum::getNames();

        $this->assertIsArray($keys);
        $this->assertContains('agent', $keys);
        $this->assertContains('organization', $keys);
        $this->assertCount(2, $keys);

        $values = AuthorizedByEnum::getValues();

        $this->assertIsArray($values);
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);
        $this->assertCount(2, $values);
    }

    public function testEnumUsesEnumTrait(): void
    {
        $usedTraits = class_uses(AuthorizedByEnum::class);

        $this->assertIsArray($usedTraits);
        $this->assertArrayHasKey(EnumTrait::class, $usedTraits);
    }
}

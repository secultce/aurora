<?php

declare(strict_types=1);

namespace App\Tests\Unit\Enum;

use App\Enum\FlashMessageTypeEnum;
use App\Enum\Trait\EnumTrait;
use PHPUnit\Framework\TestCase;

class FlashMessageTypeEnumTest extends TestCase
{
    public function testEnumCasesHaveCorrectValues(): void
    {
        $this->assertSame('success', FlashMessageTypeEnum::SUCCESS->value);
        $this->assertSame('error', FlashMessageTypeEnum::ERROR->value);
    }

    public function testEnumTraitMethods(): void
    {
        $keys = FlashMessageTypeEnum::getNames();

        $this->assertIsArray($keys);
        $this->assertContains('success', $keys);
        $this->assertContains('error', $keys);
        $this->assertCount(2, $keys);

        $values = FlashMessageTypeEnum::getValues();

        $this->assertIsArray($values);
        $this->assertContains('success', $values);
        $this->assertContains('error', $values);
        $this->assertCount(2, $values);
    }

    public function testEnumUsesEnumTrait(): void
    {
        $usedTraits = class_uses(FlashMessageTypeEnum::class);

        $this->assertIsArray($usedTraits);
        $this->assertArrayHasKey(EnumTrait::class, $usedTraits);
    }
}

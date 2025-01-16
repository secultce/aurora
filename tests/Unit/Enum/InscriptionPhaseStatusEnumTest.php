<?php

declare(strict_types=1);

namespace App\Tests\Unit\Enum;

use App\Enum\InscriptionPhaseStatusEnum;
use App\Enum\Trait\EnumTrait;
use PHPUnit\Framework\TestCase;

class InscriptionPhaseStatusEnumTest extends TestCase
{
    public function testEnumCasesHaveCorrectValues(): void
    {
        $this->assertSame(1, InscriptionPhaseStatusEnum::ACTIVE->value);
        $this->assertSame(2, InscriptionPhaseStatusEnum::INACTIVE->value);
        $this->assertSame(3, InscriptionPhaseStatusEnum::SUSPENDED->value);
    }

    public function testEnumTraitMethods(): void
    {
        $keys = InscriptionPhaseStatusEnum::getNames();

        $this->assertIsArray($keys);
        $this->assertContains('active', $keys);
        $this->assertContains('inactive', $keys);
        $this->assertContains('suspended', $keys);
        $this->assertCount(3, $keys);

        $values = InscriptionPhaseStatusEnum::getValues();

        $this->assertIsArray($values);
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);
        $this->assertContains(3, $values);
        $this->assertCount(3, $values);
    }

    public function testEnumUsesEnumTrait(): void
    {
        $usedTraits = class_uses(InscriptionPhaseStatusEnum::class);

        $this->assertIsArray($usedTraits);
        $this->assertArrayHasKey(EnumTrait::class, $usedTraits);
    }
}

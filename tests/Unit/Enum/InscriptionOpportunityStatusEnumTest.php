<?php

declare(strict_types=1);

namespace App\Tests\Unit\Enum;

use App\Enum\InscriptionOpportunityStatusEnum;
use App\Enum\Trait\EnumTrait;
use PHPUnit\Framework\TestCase;

class InscriptionOpportunityStatusEnumTest extends TestCase
{
    public function testEnumCasesHaveCorrectValues(): void
    {
        $this->assertSame(1, InscriptionOpportunityStatusEnum::ACTIVE->value);
        $this->assertSame(2, InscriptionOpportunityStatusEnum::INACTIVE->value);
        $this->assertSame(3, InscriptionOpportunityStatusEnum::SUSPENDED->value);
    }

    public function testEnumTraitMethods(): void
    {
        $keys = InscriptionOpportunityStatusEnum::getNames();

        $this->assertIsArray($keys);
        $this->assertContains('active', $keys);
        $this->assertContains('inactive', $keys);
        $this->assertContains('suspended', $keys);
        $this->assertCount(3, $keys);

        $values = InscriptionOpportunityStatusEnum::getValues();

        $this->assertIsArray($values);
        $this->assertContains(1, $values);
        $this->assertContains(2, $values);
        $this->assertContains(3, $values);
        $this->assertCount(3, $values);
    }

    public function testEnumUsesEnumTrait(): void
    {
        $usedTraits = class_uses(InscriptionOpportunityStatusEnum::class);

        $this->assertIsArray($usedTraits);
        $this->assertArrayHasKey(EnumTrait::class, $usedTraits);
    }
}

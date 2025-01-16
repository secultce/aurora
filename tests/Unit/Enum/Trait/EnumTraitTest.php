<?php

declare(strict_types=1);

namespace App\Tests\Unit\Enum\Trait;

use PHPUnit\Framework\TestCase;

class EnumTraitTest extends TestCase
{
    public function testGetName(): void
    {
        $this->assertSame('first', DummyEnum::getName(1));
        $this->assertSame('second', DummyEnum::getName(2));
        $this->assertSame('third', DummyEnum::getName(3));
    }

    public function testGetNames(): void
    {
        $names = DummyEnum::getNames();
        $this->assertSame(['first', 'second', 'third'], $names);

        $uppercaseNames = DummyEnum::getNames('uppercase');
        $this->assertSame(['FIRST', 'SECOND', 'THIRD'], $uppercaseNames);

        $uppercaseNames = DummyEnum::getNames('capitalize');
        $this->assertSame(['First', 'Second', 'Third'], $uppercaseNames);
    }

    public function testGetValues(): void
    {
        $values = DummyEnum::getValues();
        $this->assertSame([1, 2, 3], $values);
    }

    public function testFromName(): void
    {
        $this->assertSame(DummyEnum::FIRST, DummyEnum::fromName('first'));
        $this->assertSame(DummyEnum::FIRST, DummyEnum::fromName('FIRST'));
        $this->assertSame(DummyEnum::FIRST, DummyEnum::fromName('first'));
        $this->assertSame(DummyEnum::FIRST, DummyEnum::fromName('FIRST'));
        $this->assertSame(DummyEnum::FIRST, DummyEnum::fromName('first'));
        $this->assertSame(DummyEnum::FIRST, DummyEnum::fromName('FIRST'));
        $this->assertNull(DummyEnum::fromName('nonexistent'));
    }
}

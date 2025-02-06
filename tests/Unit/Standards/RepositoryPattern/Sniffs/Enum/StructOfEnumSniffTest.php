<?php

declare(strict_types=1);

namespace App\Tests\Unit\Standards\RepositoryPattern\Sniffs\Enum;

use App\Standards\RepositoryPattern\Sniffs\Enum\StructOfEnumSniff;
use PHP_CodeSniffer\Files\File;
use PHPUnit\Framework\TestCase;

class StructOfEnumSniffTest extends TestCase
{
    public function testRegisterReturnsCorrectTokens(): void
    {
        $sniff = new StructOfEnumSniff();
        $this->assertSame([T_ENUM], $sniff->register());
    }

    public function testSniffAcceptsEnumWithTrait(): void
    {
        $sniff = new StructOfEnumSniff();
        $fileMock = $this->createMock(File::class);

        $fileMock->method('getFilename')
            ->willReturn('/src/Enum/SomeEnum.php');

        $tokens = [
            [
                'code' => T_ENUM,
                'content' => 'enum',
                'scope_opener' => 2,
                'scope_closer' => 7,
            ],
            [
                'code' => T_STRING,
                'content' => 'SomeEnum',
            ],
            [
                'code' => T_OPEN_CURLY_BRACKET,
                'content' => '{',
            ],
            [
                'code' => T_USE,
                'content' => 'use',
            ],
            [
                'code' => T_STRING,
                'content' => 'EnumTrait',
            ],
            [
                'code' => T_SEMICOLON,
                'content' => ';',
            ],
            [
                'code' => T_CLOSE_CURLY_BRACKET,
                'content' => '}',
            ],
        ];

        $fileMock->method('getTokens')->willReturn($tokens);
        $fileMock->method('findNext')->willReturn(5);

        $fileMock->expects($this->never())
            ->method('addError');

        $sniff->process($fileMock, 0);
    }

    public function testSniffDetectsNoUsageTrait(): void
    {
        $sniff = new StructOfEnumSniff();
        $fileMock = $this->createMock(File::class);

        $fileMock->method('getFilename')
            ->willReturn('/src/Enum/SomeEnum.php');

        $fileMock->method('getTokens')->willReturn(self::invalidTokens());
        $fileMock->method('findNext')->willReturn(false);

        $fileMock->expects($this->once())
            ->method('addError')
            ->with(
                'Enums must use EnumTrait.',
                $this->anything(),
                'EnumTraitMissing'
            );

        $sniff->process($fileMock, 0);
    }

    public function testSniffIgnoresNonEnumFiles(): void
    {
        $sniff = new StructOfEnumSniff();
        $fileMock = $this->createMock(File::class);

        $fileMock->method('getFilename')
            ->willReturn('/src/SomeClass.php');

        $fileMock->method('getTokens')->willReturn(self::invalidTokens());
        $fileMock->method('findNext')->willReturn(false);

        $fileMock->expects($this->never())
            ->method('addError');

        $sniff->process($fileMock, 0);
    }

    private function invalidTokens(): array
    {
        return [
            [
                'code' => T_ENUM,
                'content' => 'enum',
                'scope_opener' => 2,
                'scope_closer' => 7,
            ],
            [
                'code' => T_STRING,
                'content' => 'SomeEnum',
            ],
            [
                'code' => T_OPEN_CURLY_BRACKET,
                'content' => '{',
            ],
            [
                'code' => T_CASE,
                'content' => 'case',
            ],
            [
                'code' => T_STRING,
                'content' => 'AGENT',
            ],
            [
                'code' => T_LNUMBER,
                'content' => '1',
            ],
            [
                'code' => T_CLOSE_CURLY_BRACKET,
                'content' => '}',
            ],
        ];
    }
}

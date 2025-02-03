<?php

declare(strict_types=1);

namespace App\Tests\Unit\Standards\RepositoryPattern\Sniffs\Controllers;

use App\Standards\RepositoryPattern\Sniffs\Controllers\DisallowRepositoryUsageSniff;
use PHP_CodeSniffer\Files\File;
use PHPUnit\Framework\TestCase;

class DisallowRepositoryUsageSniffTest extends TestCase
{
    public function testRegisterReturnsCorrectTokens(): void
    {
        $sniff = new DisallowRepositoryUsageSniff();
        $this->assertSame([T_USE], $sniff->register());
    }

    public function testSniffDetectsRepositoryUsage(): void
    {
        $sniff = new DisallowRepositoryUsageSniff();
        $fileMock = $this->createMock(File::class);

        $fileMock->method('getFilename')
            ->willReturn('/src/Controller/Api/SomeController.php');

        $tokens = [
            ['content' => 'use'],
            ['content' => ' App\\Repository\\SomeRepository'],
            ['content' => ';'],
        ];

        $fileMock->method('getTokens')->willReturn($tokens);
        $fileMock->method('findNext')->willReturn(2);

        $fileMock->expects($this->once())
            ->method('addError')
            ->with(
                'Controllers must not use repositories directly; use services instead.',
                $this->anything(),
                'RepositoryUsageDetected'
            );

        $sniff->process($fileMock, 0);
    }

    public function testSniffIgnoresNonControllerFiles(): void
    {
        $sniff = new DisallowRepositoryUsageSniff();
        $fileMock = $this->createMock(File::class);

        $fileMock->method('getFilename')
            ->willReturn('/src/Service/SomeService.php');

        $fileMock->expects($this->never())->method('addError');

        $sniff->process($fileMock, 0);
    }

    public function testSniffIgnoresNonRepositoryUsage(): void
    {
        $sniff = new DisallowRepositoryUsageSniff();
        $fileMock = $this->createMock(File::class);

        $fileMock->method('getFilename')
            ->willReturn('/src/Controller/Api/SomeController.php');

        $tokens = [
            ['content' => 'use'],
            ['content' => ' App\\Service\\SomeService'],
            ['content' => ';'],
        ];

        $fileMock->method('getTokens')->willReturn($tokens);
        $fileMock->method('findNext')->willReturn(2);

        $fileMock->expects($this->never())->method('addError');

        $sniff->process($fileMock, 0);
    }
}

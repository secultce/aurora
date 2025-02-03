<?php

declare(strict_types=1);

namespace App\Standards\RepositoryPattern\Sniffs\Controllers;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowRepositoryUsageSniff implements Sniff
{
    public function register(): array
    {
        return [T_USE];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $fileName = $phpcsFile->getFilename();

        if (false === str_contains($fileName, 'src/Controller')) {
            return;
        }

        $endPtr = $phpcsFile->findNext([T_SEMICOLON, T_AS], $stackPtr);
        $className = '';
        for ($i = $stackPtr + 1; $i < $endPtr; $i++) {
            $className .= $tokens[$i]['content'];
        }

        if (true === str_contains($className, 'Repository')) {
            $error = 'Controllers must not use repositories directly; use services instead.';
            $phpcsFile->addError($error, $stackPtr, 'RepositoryUsageDetected');
        }
    }
}

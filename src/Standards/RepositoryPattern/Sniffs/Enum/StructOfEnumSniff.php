<?php

declare(strict_types=1);

namespace App\Standards\RepositoryPattern\Sniffs\Enum;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class StructOfEnumSniff implements Sniff
{
    public function register(): array
    {
        return [T_ENUM];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $fileName = $phpcsFile->getFilename();

        if (false === str_contains($fileName, 'src/Enum')) {
            return;
        }

        $traitFound = false;
        $enumOpenBrace = $tokens[$stackPtr]['scope_opener'];
        $enumCloseBrace = $tokens[$stackPtr]['scope_closer'];

        for ($i = $enumOpenBrace + 1; $i < $enumCloseBrace; $i++) {
            if (T_USE !== $tokens[$i]['code']) {
                continue;
            }

            $endPtr = $phpcsFile->findNext([T_SEMICOLON, T_AS], $i);
            $traitName = '';

            for ($j = $i + 1; $j < $endPtr; $j++) {
                $traitName .= $tokens[$j]['content'];
            }

            $traitName = trim($traitName);

            if ('EnumTrait' === $traitName) {
                $traitFound = true;
                break;
            }
        }

        if (false === $traitFound) {
            $error = 'Enums must use EnumTrait.';
            $phpcsFile->addError($error, $stackPtr, 'EnumTraitMissing');
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Yaml\Yaml;

class TranslationsTest extends KernelTestCase
{
    private const array TRANSLATION_FILES = [
        'translations/messages.pt-br.yaml',
        'translations/messages.en.yaml',
        'translations/messages.es.yaml',
    ];

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testTranslationsFilesExists(): void
    {
        foreach (self::TRANSLATION_FILES as $file) {
            $this->assertFileExists(self::$kernel->getProjectDir().'/'.$file);
        }
    }

    public function testTranslationsHaveSameKeys(): void
    {
        $ptBRTranslation = Yaml::parseFile(self::$kernel->getProjectDir().'/'.self::TRANSLATION_FILES[0]);
        $translations = array_slice(self::TRANSLATION_FILES, 1);

        foreach ($translations as $file) {
            $translationArray = Yaml::parseFile(self::$kernel->getProjectDir().'/'.$file);
            $this->testKeyExists($ptBRTranslation, $translationArray, $file);
        }
    }

    private function testKeyExists(array $firstArray, array $secondArray, string $fileName = '', string $prefix = ''): void
    {
        foreach ($firstArray as $key => $value) {
            $fullKey = $prefix ? $prefix.'.'.$key : $key;
            $this->assertArrayHasKey(
                $key,
                $secondArray,
                "The key $fullKey is missing in the file $fileName."
            );

            if (is_array($value)) {
                $this->testKeyExists($value, $secondArray[$key] ?? [], $fileName, $fullKey);
            }
        }
    }
}

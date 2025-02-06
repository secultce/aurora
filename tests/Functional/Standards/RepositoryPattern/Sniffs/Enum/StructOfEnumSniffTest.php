<?php

declare(strict_types=1);

namespace App\Tests\Functional\Standards\RepositoryPattern\Sniffs\Enum;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Ruleset;
use PHPUnit\Framework\TestCase;

class StructOfEnumSniffTest extends TestCase
{
    private string $tempDir;
    private string $tempFilePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tempDir = sys_get_temp_dir().'/src/Enum';
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0o777, true);
        }

        $this->tempFilePath = $this->tempDir.'/SomeEnum.php';
        $this->createTemporaryFile($this->tempFilePath);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->tempFilePath)) {
            unlink($this->tempFilePath);
        }
        if (is_dir($this->tempDir)) {
            rmdir($this->tempDir);
        }
        if (is_dir(dirname($this->tempDir))) {
            rmdir(dirname($this->tempDir));
        }

        parent::tearDown();
    }

    public function testRepositoryUsageInControllerIsDetected(): void
    {
        $config = new Config();

        $rulesetPath = dirname(__DIR__, 6).'/src/Standards/RepositoryPattern/ruleset.xml';
        $config->standards = [$rulesetPath];

        $ruleset = new Ruleset($config);

        $file = new LocalFile($this->tempFilePath, $ruleset, $config);
        $file->process();

        $errors = $file->getErrors();
        $this->assertNotEmpty($errors, 'Expected an error to be detected.');

        $foundError = $this->containsErrorMessage(
            $errors
        );

        $this->assertTrue($foundError, 'Expected error message not found.');
    }

    // phpcs:disable RepositoryPattern.Enum.StructOfEnum
    private function createTemporaryFile(string $path): void
    {
        $content = <<<'PHP'
            <?php

            declare(strict_types=1);

            namespace App\Enum;

            enum SomeEnum: int
            {
                case CICLANO = 1;
                case FULANO = 2;
            }
            PHP;

        $tempFile = fopen($path, 'w');
        if (false === $tempFile) {
            $this->fail('Failed to create temporary file.');
        }

        fwrite($tempFile, $content);
        fclose($tempFile);
    }
    // phpcs:enable RepositoryPattern.Enum.StructOfEnum

    private function containsErrorMessage(array $errors): bool
    {
        return array_any(
            $errors,
            fn ($lineErrors) => array_any(
                $lineErrors,
                fn ($errorMessages) => array_any(
                    $errorMessages,
                    fn ($errorMessage) => str_contains($errorMessage['message'], 'Enums must use EnumTrait')
                )
            )
        );
    }
}

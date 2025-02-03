<?php

declare(strict_types=1);

namespace App\Tests\Functional\Standards\RepositoryPattern\Sniffs\Controllers;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Ruleset;
use PHPUnit\Framework\TestCase;

class DisallowRepositoryUsageSniffTest extends TestCase
{
    private string $tempDir;
    private string $tempFilePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tempDir = sys_get_temp_dir().'/src/Controller';
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0o777, true);
        }

        $this->tempFilePath = $this->tempDir.'/UserController.php';
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

    // phpcs:disable RepositoryPattern.Controllers.DisallowRepositoryUsage
    private function createTemporaryFile(string $path): void
    {
        $content = <<<'PHP'
            <?php

            declare(strict_types=1);

            namespace App\Controller;

            use App\Repository\UserRepository;

            class UserController
            {
                private $userRepository;

                public function __construct(UserRepository $userRepository)
                {
                    $this->userRepository = $userRepository;
                }

                public function index()
                {
                    $users = $this->userRepository->findAll();
                }
            }
            PHP;

        $tempFile = fopen($path, 'w');
        if (false === $tempFile) {
            $this->fail('Failed to create temporary file.');
        }

        fwrite($tempFile, $content);
        fclose($tempFile);
    }
    // phpcs:enable RepositoryPattern.Controllers.DisallowRepositoryUsage

    private function containsErrorMessage(array $errors): bool
    {
        return array_any(
            $errors,
            fn ($lineErrors) => array_any(
                $lineErrors,
                fn ($errorMessages) => array_any(
                    $errorMessages,
                    fn ($errorMessage) => str_contains($errorMessage['message'], 'Controllers must not use repositories directly')
                )
            )
        );
    }
}

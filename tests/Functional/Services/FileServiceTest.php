<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\Service\FileService;
use League\Flysystem\UnableToReadFile;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FileServiceTest extends KernelTestCase
{
    private FileService $fileService;

    private const string FILE = 'hello.csv';
    private const string CONTENT = 'hello,world';

    protected function setUp(): void
    {
        self::bootKernel();

        $this->fileService = self::getContainer()->get(FileService::class);
    }

    public function testUploadAndReadFile(): void
    {
        $this->fileService->uploadFile(self::FILE, self::CONTENT);

        $readContent = $this->fileService->readFile(self::FILE);
        $this->assertEquals(self::CONTENT, $readContent);

        $this->fileService->deleteFile(self::FILE);
    }

    public function testFileDeletion(): void
    {
        $this->fileService->uploadFile(self::FILE, self::CONTENT);
        $this->fileService->deleteFile(self::FILE);

        $this->expectException(UnableToReadFile::class);
        $this->fileService->readFile(self::FILE);
    }
}

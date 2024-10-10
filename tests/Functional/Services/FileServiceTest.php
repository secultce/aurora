<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\Service\FileService;
use Exception;
use League\Flysystem\UnableToReadFile;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;

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

    public function testUploadImage(): void
    {
        $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO9TXL0Y4OHwAAAABJRU5ErkJggg==';

        $file = $this->fileService->uploadImage('/img', $base64Image);

        $this->assertInstanceOf(File::class, $file);
        $this->assertFileExists($file->getPathname());

        $this->fileService->deleteFile($file->getPathname());
    }

    public function testUploadImageWithInvalidBase64(): void
    {
        $base64Image = 'data:image/png;base64,iVBORw0K$GgoAAAANSUhEUgAAAAUA';
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('base64 decode failed');

        $this->fileService->uploadImage('img', $base64Image);
    }

    public function testUploadImageWithInvalidCode(): void
    {
        $invalidMimeTypeImage = ':invalid_mime;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO9TXL0Y4OHwAAAABJRU5ErkJggg==';

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('invalid base64 image');

        $this->fileService->uploadImage('/img', $invalidMimeTypeImage);
    }
}

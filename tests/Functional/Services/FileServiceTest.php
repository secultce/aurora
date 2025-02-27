<?php

declare(strict_types=1);

namespace App\Tests\Functional\Services;

use App\Exception\File\InvalidFileExtensionException;
use App\Exception\File\InvalidFileMimeTypeException;
use App\Service\FileService;
use App\Tests\Fixtures\ImageTestFixtures;
use League\Flysystem\UnableToReadFile;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function testDeleteFileByUrl(): void
    {
        $this->fileService->uploadFile(self::FILE, self::CONTENT);

        $storageUrl = $this->fileService->getFileUrl('');
        $fileUrl = $storageUrl.'/'.self::FILE;
        $filePath = dirname(__DIR__, 2).'/assets/'.self::FILE;

        $this->fileService->deleteFileByUrl($fileUrl);

        $this->assertFalse(file_exists($filePath));
    }

    public function testUploadImage(): void
    {
        $uploadedFile = ImageTestFixtures::getImageValid();

        $file = $this->fileService->uploadImage('/img', $uploadedFile);

        $this->assertInstanceOf(File::class, $file);
        $this->assertFileExists($file->getPathname());
    }

    public function testCannotUploadImageWithMimeTypeIncorrect(): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'test_');
        file_put_contents($tempFile, 'Test image content');

        $uploadedFile = new UploadedFile(
            $tempFile,
            'test_image.png',
            'image/png',
            null,
            true
        );

        $this->expectException(InvalidFileMimeTypeException::class);
        $this->fileService->uploadImage('/img', $uploadedFile);
    }

    public function testCannotUploadImageWithExtensionIncorrect(): void
    {
        $path = ImageTestFixtures::getImageValidPath();

        $uploadedFile = new UploadedFile($path, 'image-valid.txt', 'image/png', null, true);

        $this->expectException(InvalidFileExtensionException::class);
        $this->fileService->uploadImage('/img', $uploadedFile);
    }
}

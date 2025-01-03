<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Interface\FileServiceInterface;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class FileService implements FileServiceInterface
{
    private const ASSETS_PATTERN = '/^\/var\/www(?:\/var)?\/assets(.*)/';
    private string $storageDir;
    private string $storageUrl;

    public function __construct(
        private FilesystemOperator $filesystem,
        private ParameterBagInterface $parameterBag,
    ) {
        $this->storageDir = $this->parameterBag->get('app.dir.storage');
        $this->storageUrl = $this->parameterBag->get('app.url.storage');
    }

    public function uploadFile(string $filename, string $content): void
    {
        $this->filesystem->write($filename, $content);
    }

    public function readFile(string $filename): string
    {
        return $this->filesystem->read($filename);
    }

    public function deleteFile(string $filename): void
    {
        if (1 === preg_match(self::ASSETS_PATTERN, $filename, $matches)) {
            $filename = $matches[1];
        }

        $this->filesystem->delete($filename);
    }

    public function deleteFileByUrl(string $url): void
    {
        $filename = str_replace($this->storageUrl, '', $url);

        $this->filesystem->delete($filename);
    }

    public function getFileUrl(string $path): string
    {
        if (1 === preg_match(self::ASSETS_PATTERN, $path, $matches)) {
            $path = $matches[1];
        }

        return $path;
    }

    /**
     * @throws FilesystemException
     */
    public function uploadImage(string $path, UploadedFile $uploadedFile): File
    {
        $fileName = uniqid('', true).'.'.$uploadedFile->guessExtension();
        $filePath = rtrim($path, '/').'/'.$fileName;

        $stream = fopen($uploadedFile->getRealPath(), 'r');
        $this->filesystem->writeStream($filePath, $stream);
        fclose($stream);

        return new File($this->storageDir.$filePath);
    }

    public function urlOfImage(string $path): string
    {
        return $this->storageUrl.'/'.$path;
    }
}

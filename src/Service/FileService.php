<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Interface\FileServiceInterface;
use League\Flysystem\FilesystemOperator;

readonly class FileService implements FileServiceInterface
{
    public function __construct(
        private FilesystemOperator $filesystem
    ) {
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
        $this->filesystem->delete($filename);
    }
}

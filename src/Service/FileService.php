<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Interface\FileServiceInterface;
use Exception;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;

readonly class FileService implements FileServiceInterface
{
    private string $storageDir;

    public function __construct(
        private FilesystemOperator $filesystem,
        private ParameterBagInterface $parameterBag,
    ) {
        $this->storageDir = $this->parameterBag->get('app.dir.storage');
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
        if (1 === preg_match('/^\/var\/www(?:\/var)?\/storage(.*)/', $filename, $matches)) {
            $filename = $matches[1];
        }

        $this->filesystem->delete($filename);
    }

    public function deleteFileByUrl(string $url): void
    {
        $filename = str_replace($this->parameterBag->get('app.url.storage'), '', $url);

        $this->filesystem->delete($filename);
    }

    public function getFileUrl(string $path): string
    {
        if (1 === preg_match('/^\/var\/www(?:\/var)?\/storage(.*)/', $path, $matches)) {
            $path = $matches[1];
        }

        return $this->parameterBag->get('app.url.storage').$path;
    }

    public function uploadImage(string $path, string $base64Image): File
    {
        if (1 === preg_match('/^\/var\/www(?:\/var)?\/storage(.*)/', $path, $matches)) {
            $path = $matches[1];
        }

        if (1 === preg_match('/^data:(.*?);base64,(.*)$/', $base64Image, $matches)) {
            $mimeType = $matches[1];
            $base64Data = $matches[2];

            $imageData = base64_decode($base64Data, true);

            if (false === $imageData) {
                throw new Exception('base64 decode failed');
            }

            $extension = explode('/', $mimeType)[1];
            $fileName = uniqid().'.'.$extension;
            $filePath = $path.'/'.$fileName;

            $this->filesystem->write($filePath, $imageData);

            return new File($this->storageDir.$filePath);
        }

        throw new Exception('invalid base64 image');
    }

    public function urlOfImage($path): string
    {
        $this->parameterBag->get('app.dir.agent.profile');

        return $this->parameterBag->get('app.url.storage').'/'.$path;
    }
}

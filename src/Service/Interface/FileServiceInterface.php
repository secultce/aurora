<?php

declare(strict_types=1);

namespace App\Service\Interface;

use Symfony\Component\HttpFoundation\File\File;

interface FileServiceInterface
{
    public function uploadFile(string $filename, string $content): void;

    public function uploadImage(string $path, string $base64Image): File;

    public function readFile(string $filename): string;

    public function deleteFile(string $filename): void;

    public function deleteFileByUrl(string $url): void;

    public function getFileUrl(string $path): string;

    public function urlOfImage($path): string;
}

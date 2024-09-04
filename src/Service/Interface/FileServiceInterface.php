<?php

declare(strict_types=1);

namespace App\Service\Interface;

interface FileServiceInterface
{
    public function uploadFile(string $filename, string $content): void;

    public function readFile(string $filename): string;

    public function deleteFile(string $filename): void;
}

<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ImageTestFixtures
{
    public static function getImageValid(): UploadedFile
    {
        return self::getUploadedFile('image-valid.png');
    }

    public static function getImageValidPath(): string
    {
        $path = realpath(sprintf('%s/images/%s', __DIR__, 'image-valid.png'));

        if (!file_exists($path)) {
            throw new RuntimeException("Image file not found: $path");
        }

        return $path;
    }

    public static function getImageMoreThan2mb(): UploadedFile
    {
        return self::getUploadedFile('image-more-than-2mb.jpeg');
    }

    public static function getGif(): UploadedFile
    {
        return self::getUploadedFile('image.gif');
    }

    private static function getUploadedFile(string $image): UploadedFile
    {
        $path = realpath(sprintf('%s/images/%s', __DIR__, $image));

        if (!file_exists($path)) {
            throw new RuntimeException("Image file not found: $path");
        }

        $type = mime_content_type($path);

        return new UploadedFile($path, $image, $type, null, true);
    }
}

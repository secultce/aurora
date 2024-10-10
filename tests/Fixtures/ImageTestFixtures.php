<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

final class ImageTestFixtures
{
    public static function getImageValid(): string
    {
        return self::getCodeBase64ToImage('image-valid.png');
    }

    public static function getImageMoreThan2mb(): string
    {
        return self::getCodeBase64ToImage('image-more-than-2mb.jpeg');
    }

    public static function getGif(): string
    {
        return self::getCodeBase64ToImage('aurora.gif');
    }

    private static function getCodeBase64ToImage(string $image): string
    {
        $path = sprintf('%s/images/%s', __DIR__, $image);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        return 'data:image/'.$type.';base64,'.base64_encode($data);
    }
}

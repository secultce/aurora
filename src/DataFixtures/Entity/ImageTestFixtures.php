<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

final class ImageTestFixtures
{
    public static function getAgentImage(): string
    {
        return self::getCodeBase64ToImage('agent.png');
    }

    private static function getCodeBase64ToImage(string $image): string
    {
        $path = sprintf('%s/images/%s', __DIR__, $image);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        return 'data:image/'.$type.';base64,'.base64_encode($data);
    }
}

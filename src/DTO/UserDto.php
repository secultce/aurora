<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\Image;

class UserDto
{
    public const string CREATE = 'create';

    public const string UPDATE = 'update';

    #[Image(maxSize: (2000000), mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'], groups: [self::CREATE, self::UPDATE])]
    public ?File $image = null;
}

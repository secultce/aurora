<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\EnumTrait;

enum FlashMessageTypeEnum: string
{
    use EnumTrait;

    case SUCCESS = 'success';
    case ERROR = 'error';
}

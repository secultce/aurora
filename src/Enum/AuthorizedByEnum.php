<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\EnumTrait;

enum AuthorizedByEnum: int
{
    use EnumTrait;

    case AGENT = 1;
    case ORGANIZATION = 2;
}

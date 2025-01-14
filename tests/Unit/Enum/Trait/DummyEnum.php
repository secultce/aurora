<?php

declare(strict_types=1);

namespace App\Tests\Unit\Enum\Trait;

use App\Enum\Trait\EnumTrait;

enum DummyEnum: int
{
    use EnumTrait;

    case FIRST = 1;
    case SECOND = 2;
    case THIRD = 3;
}

<?php

declare(strict_types=1);

namespace App\Exception\Space;

use App\Exception\ResourceNotFoundException;

class SpaceResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Space';
}

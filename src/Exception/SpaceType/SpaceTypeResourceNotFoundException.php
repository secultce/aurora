<?php

declare(strict_types=1);

namespace App\Exception\SpaceType;

use App\Exception\ResourceNotFoundException;

class SpaceTypeResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'SpaceType';
}

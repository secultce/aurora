<?php

declare(strict_types=1);

namespace App\Exception\Tag;

use App\Exception\ResourceNotFoundException;

class TagResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Tag';
}

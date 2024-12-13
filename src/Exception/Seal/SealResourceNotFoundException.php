<?php

declare(strict_types=1);

namespace App\Exception\Seal;

use App\Exception\ResourceNotFoundException;

class SealResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Seal';
}

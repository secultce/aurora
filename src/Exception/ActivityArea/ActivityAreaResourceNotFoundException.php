<?php

declare(strict_types=1);

namespace App\Exception\ActivityArea;

use App\Exception\ResourceNotFoundException;

class ActivityAreaResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'ActivityArea';
}

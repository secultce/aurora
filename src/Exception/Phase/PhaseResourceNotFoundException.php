<?php

declare(strict_types=1);

namespace App\Exception\Phase;

use App\Exception\ResourceNotFoundException;

class PhaseResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Phase';
}

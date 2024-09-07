<?php

declare(strict_types=1);

namespace App\Exception\Initiative;

use App\Exception\ResourceNotFoundException;

class InitiativeResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Initiative';
}

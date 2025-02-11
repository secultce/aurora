<?php

declare(strict_types=1);

namespace App\Exception\EventActivity;

use App\Exception\ResourceNotFoundException;

class EventActivityResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'EventActivity';
}

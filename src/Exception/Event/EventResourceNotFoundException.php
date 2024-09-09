<?php

declare(strict_types=1);

namespace App\Exception\Event;

use App\Exception\ResourceNotFoundException;

class EventResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Event';
}

<?php

declare(strict_types=1);

namespace App\Exception\Agent;

use App\Exception\ResourceNotFoundException;

class AgentResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Agent';
}

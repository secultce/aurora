<?php

declare(strict_types=1);

namespace App\Exception\Opportunity;

use App\Exception\ResourceNotFoundException;

class OpportunityResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Opportunity';
}

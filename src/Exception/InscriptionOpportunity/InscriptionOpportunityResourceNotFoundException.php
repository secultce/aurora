<?php

declare(strict_types=1);

namespace App\Exception\InscriptionOpportunity;

use App\Exception\ResourceNotFoundException;

class InscriptionOpportunityResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'InscriptionOpportunity';
}

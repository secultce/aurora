<?php

declare(strict_types=1);

namespace App\Exception\Organization;

use App\Exception\ResourceNotFoundException;

class OrganizationResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Organization';
}

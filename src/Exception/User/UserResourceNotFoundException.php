<?php

declare(strict_types=1);

namespace App\Exception\User;

use App\Exception\ResourceNotFoundException;

class UserResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'User';
}

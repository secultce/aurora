<?php

namespace App\Exception\Address;

use App\Exception\ResourceNotFoundException;

class AddressResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Address';
}

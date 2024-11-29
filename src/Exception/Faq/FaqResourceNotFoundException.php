<?php

declare(strict_types=1);

namespace App\Exception\Faq;

use App\Exception\ResourceNotFoundException;

class FaqResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'Faq';
}

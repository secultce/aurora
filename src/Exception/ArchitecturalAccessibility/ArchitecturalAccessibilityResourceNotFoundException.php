<?php

declare(strict_types=1);

namespace App\Exception\ArchitecturalAccessibility;

use App\Exception\ResourceNotFoundException;

class ArchitecturalAccessibilityResourceNotFoundException extends ResourceNotFoundException
{
    protected const string RESOURCE = 'ArchitecturalAccessibility';
}

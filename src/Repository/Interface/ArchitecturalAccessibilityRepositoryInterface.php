<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use App\Entity\ArchitecturalAccessibility;

interface ArchitecturalAccessibilityRepositoryInterface
{
    public function save(ArchitecturalAccessibility $architecturalAccessibility): ArchitecturalAccessibility;

    public function remove(ArchitecturalAccessibility $architecturalAccessibility): void;
}

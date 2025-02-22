<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\ArchitecturalAccessibility;
use Symfony\Component\Uid\Uuid;

interface ArchitecturalAccessibilityServiceInterface
{
    public function create(array $architecturalAccessibility): ArchitecturalAccessibility;

    public function update(Uuid $id, array $architecturalAccessibility): ArchitecturalAccessibility;

    public function getOne(Uuid $id): ArchitecturalAccessibility;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;
}

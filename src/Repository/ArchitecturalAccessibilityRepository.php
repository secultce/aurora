<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ArchitecturalAccessibility;
use App\Repository\Interface\ArchitecturalAccessibilityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class ArchitecturalAccessibilityRepository extends AbstractRepository implements ArchitecturalAccessibilityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchitecturalAccessibility::class);
    }

    public function save(ArchitecturalAccessibility $architecturalAccessibility): ArchitecturalAccessibility
    {
        $this->getEntityManager()->persist($architecturalAccessibility);
        $this->getEntityManager()->flush();

        return $architecturalAccessibility;
    }

    public function remove(ArchitecturalAccessibility $architecturalAccessibility): void
    {
        $this->getEntityManager()->remove($architecturalAccessibility);
        $this->getEntityManager()->flush();
    }
}

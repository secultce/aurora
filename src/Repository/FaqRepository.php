<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Faq;
use App\Repository\Interface\FaqRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class FaqRepository extends AbstractRepository implements FaqRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faq::class);
    }
}

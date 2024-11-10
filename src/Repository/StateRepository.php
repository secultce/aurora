<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\State;
use App\Repository\Interface\StateRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class StateRepository extends AbstractRepository implements StateRepositoryInterface
{
    public function __construct(ManagerRegistry $manager)
    {
        parent::__construct($manager, State::class);
    }
}

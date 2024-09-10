<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Agent;
use App\Repository\Interface\AgentRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class AgentRepository extends AbstractRepository implements AgentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agent::class);
    }

    public function save(Agent $agent): Agent
    {
        $this->getEntityManager()->persist($agent);
        $this->getEntityManager()->flush();

        return $agent;
    }
}

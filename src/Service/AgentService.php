<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Agent;
use App\Exception\Agent\AgentResourceNotFoundException;
use App\Repository\Interface\AgentRepositoryInterface;
use App\Service\Interface\AgentServiceInterface;
use Symfony\Component\Uid\Uuid;

readonly class AgentService implements AgentServiceInterface
{
    public function __construct(
        private AgentRepositoryInterface $agentRepository,
    ) {
    }

    public function get(Uuid $id): Agent
    {
        $agent = $this->agentRepository->find($id);

        if (null === $agent) {
            throw new AgentResourceNotFoundException();
        }

        return $agent;
    }

    public function list(): array
    {
        return $this->agentRepository->findAll();
    }
}

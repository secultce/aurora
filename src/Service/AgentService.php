<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Agent;
use App\Exception\Agent\AgentResourceNotFoundException;
use App\Repository\Interface\AgentRepositoryInterface;
use App\Service\Interface\AgentServiceInterface;
use DateTime;
use Symfony\Component\Uid\Uuid;

readonly class AgentService implements AgentServiceInterface
{
    private const DEFAULT_FILTERS = [
        'deletedAt' => null,
    ];

    public function __construct(
        private AgentRepositoryInterface $repository,
    ) {
    }

    public function get(Uuid $id): Agent
    {
        $agent = $this->repository->findOneBy([
            ...['id' => $id],
            ...self::DEFAULT_FILTERS,
        ]);

        if (null === $agent) {
            throw new AgentResourceNotFoundException();
        }

        return $agent;
    }

    public function list(): array
    {
        return $this->repository->findBy(self::DEFAULT_FILTERS);
    }

    public function remove(Uuid $id): void
    {
        $agent = $this->get($id);
        $agent->setDeletedAt(new DateTime());

        $this->repository->save($agent);
    }
}

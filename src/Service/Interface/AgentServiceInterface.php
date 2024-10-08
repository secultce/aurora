<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Agent;
use Symfony\Component\Uid\Uuid;

interface AgentServiceInterface
{
    public function create(array $agent): Agent;

    public function get(Uuid $id): Agent;

    public function list(int $limit = 50): array;

    public function remove(Uuid $id): void;

    public function update(Uuid $id, array $agent): Agent;
}

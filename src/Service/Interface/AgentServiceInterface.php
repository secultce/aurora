<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Agent;
use Symfony\Component\Uid\Uuid;

interface AgentServiceInterface
{
    public function get(Uuid $id): ?Agent;

    public function list(): array;
}

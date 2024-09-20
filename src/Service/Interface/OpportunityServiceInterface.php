<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Opportunity;
use Symfony\Component\Uid\Uuid;

interface OpportunityServiceInterface
{
    public function create(array $opportunity): Opportunity;

    public function get(Uuid $id): Opportunity;

    public function list(): array;

    public function remove(Uuid $id): void;
}

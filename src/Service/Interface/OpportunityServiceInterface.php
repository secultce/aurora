<?php

declare(strict_types=1);

namespace App\Service\Interface;

use App\Entity\Opportunity;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

interface OpportunityServiceInterface
{
    public function create(array $opportunity): Opportunity;

    public function get(Uuid $id): Opportunity;

    public function list(array $filters = [], int $limit = 50): array;

    public function myOpportunities(UserInterface $user): array;

    public function remove(Uuid $id): void;

    public function update(Uuid $identifier, array $opportunity): Opportunity;
}
